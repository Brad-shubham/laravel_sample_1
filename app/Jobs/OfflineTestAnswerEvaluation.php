<?php

namespace App\Jobs;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Lesson;
use App\Models\LessonStatus;
use App\Models\TestProgress;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Models\User;
use App\Notifications\CourseCompleteNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class OfflineTestAnswerEvaluation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User $student
     */
    protected $student;

    /**
     * @var Course $course
     */
    protected $course;

    /**
     * @var String
     */
    protected $message;

    /**
     * Create a new job instance.
     *
     * @param  User  $student
     * @param  Course  $course
     * @param  String  $message
     *
     * @return void
     */
    public function __construct(User $user, Course $course, string $message)
    {
        $this->student = $user;
        $this->course = $course;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $courseComplete = false;
        $certificateAssigned = false;
        $teacherId = Auth::user()->id;

        $allLessons = $this->course->lessons()->get()->toArray();
        $noOfLessonsUnlocked = $this->course->lessonsStatus()->where('student_id', $this->student->getKey())->count();

        $nextLesson = ($noOfLessonsUnlocked === count($allLessons)) ? null : $allLessons[$noOfLessonsUnlocked];

        if($nextLesson){
            $lesson = Lesson::find($nextLesson['id']);
            $hasTest = $lesson->test;
            if($hasTest){
                LessonStatus::updateOrCreate([
                    'lesson_id' => $nextLesson['id'],
                    'student_id' => $this->student->getKey(),
                ], [
                    'lesson_id' => $nextLesson['id'],
                    'student_id' => $this->student->getKey(),
                    'is_unlocked' => 1,
                ]);
            }else{
                LessonStatus::updateOrCreate([
                    'lesson_id' => $nextLesson['id'],
                    'student_id' => $this->student->getKey(),
                ], [
                    'lesson_id' => $nextLesson['id'],
                    'student_id' => $this->student->getKey(),
                    'is_unlocked' => 1,
                    'is_complete' => 1,
                ]);
            }
        }

        // Number of tests remaining in the course
        $noOfTestRemaining = $this->course->testResults()->where('student_id',
            $this->student->getKey())->where('status', '<>', TestResult::STATUS['qualified'])->count();

        // Number of lessons remaining in the course
        $noOfLessonsCompleted = $this->course->lessons()->whereHas('lessonStatus',
            function ($query) {
                $query->where('student_id', $this->student->getKey())
                    ->where('is_complete', true);
            })->count();
        $noOfLessonsRemaining = $this->course->lessons()->count() - $noOfLessonsCompleted;

        $lastLessonUnlocked = $this->course->lessonsStatus()->where('student_id',
            $this->student->getKey())->get()->last();
        $lastLessonTest = $lastLessonUnlocked->lesson->test;

        if ($lastLessonTest) {
            TestProgress::updateOrCreate([
                'test_id' => $lastLessonTest->getKey(),
                'student_id' => $this->student->getKey(),
            ], [
                'test_id' => $lastLessonTest->getKey(),
                'student_id' => $this->student->getKey(),
                'is_unlocked' => 1,
            ]);
        } elseif ($nextLesson) {
            $isCompleted = LessonStatus::where('lesson_id', $lastLessonUnlocked->lesson_id)->where('student_id',
                $this->student->getKey())->where('is_complete', true)->first();

            if ($isCompleted) {
                LessonStatus::updateOrCreate([
                    'lesson_id' => $nextLesson['id'],
                    'student_id' => $this->student->getKey(),
                ], [
                    'lesson_id' => $nextLesson['id'],
                    'student_id' => $this->student->getKey(),
                    'is_unlocked' => 1,
                ]);
            }
        }

        if ($noOfTestRemaining === 0 && $noOfLessonsRemaining === 0) {
            // Get the average score of the course
            $courseTotalMarks = $this->course->testResults()->where('status',
                TestResult::STATUS['qualified'])->where('student_id', $this->student->getKey())->sum('total_marks');
            $noOfTestResults = $this->course->testResults()->where('student_id',
                $this->student->getKey())->get();
            $totalTestMarks = $noOfTestResults->sum('total_questions') * TestQuestion::MAX_MARKS;

            $averageScore = ($courseTotalMarks / $totalTestMarks) * 100;

            CourseProgress::updateOrCreate([
                'course_id' => $this->course->getKey(),
                'student_id' => $this->student->getKey(),
            ], [
                'average_score' => number_format($averageScore, 2),
                'status' => CourseProgress::STATUS['completed'],
            ]);

            //Update Gift Sent status
            $numberOfCoursesCompleted = User::where('id', $this->student->getKey())
                ->withCount([
                    'progress' => function ($query) {
                        $query->where('status', CourseProgress::STATUS['completed']);
                    }
                ])
                ->first();

            $courses = Course::all()->count();
            if (in_array($numberOfCoursesCompleted->progress_count,
                    CourseProgress::GIFT_SENT_LEVELS) || $numberOfCoursesCompleted->progress_count === $courses) {
                CourseProgress::updateOrCreate([
                    'course_id' => $this->course->getKey(),
                    'student_id' => $this->student->getKey(),
                ], [
                    'course_id' => $this->course->getKey(),
                    'student_id' => $this->student->getKey(),
                    'gift_status' => true,
                ]);
            }

            $nextCourse = Course::where('id', '>', $this->course->getKey())->first();
            $checkNextCourse = true;

            while ($nextCourse && $checkNextCourse) {
                $nextCourseStatus = CourseProgress::where('student_id', $this->student->getKey())->where('course_id',
                    $nextCourse->getKey())->first();
                $nextCourseLesson = $nextCourse->lessons()->first();

                if (is_null($nextCourseStatus)) {
                    CourseProgress::updateOrCreate([
                        'course_id' => $nextCourse->getKey(),
                        'student_id' => $this->student->getKey(),
                    ], [
                        'course_id' => $nextCourse->getKey(),
                        'student_id' => $this->student->getKey(),
                        'status' => CourseProgress::STATUS['unlock'],
                    ]);

                    LessonStatus::updateOrCreate([
                        'lesson_id' => $nextCourseLesson->getKey(),
                        'student_id' => $this->student->getKey(),
                    ], [
                        'lesson_id' => $nextCourseLesson->getKey(),
                        'student_id' => $this->student->getKey(),
                        'is_unlocked' => true,
                    ]);
                    $checkNextCourse = false;
                } else {
                    $nextCourseLastLessonUnlocked = $nextCourse->lessonsStatus()->where('student_id',
                        $this->student->getKey())->get()->last();

                    $nextTest = $nextCourseLastLessonUnlocked->lesson->test;

                    $nextCourseAllLessons = $nextCourse->lessons()->get()->toArray();
                    $nextCourseNoOfLessonsUnlocked = $nextCourse->lessonsStatus()->where('student_id',
                        $this->student->getKey())->count();

                    $nextCourseLesson = ($nextCourseNoOfLessonsUnlocked === count($nextCourseAllLessons)) ? null : $nextCourseAllLessons[$nextCourseNoOfLessonsUnlocked];

                    if ($nextTest) {
                        TestProgress::updateOrCreate([
                            'test_id' => $nextTest->getKey(),
                            'student_id' => $this->student->getKey(),
                        ], [
                            'test_id' => $nextTest->getKey(),
                            'student_id' => $this->student->getKey(),
                            'is_unlocked' => 1,
                        ]);
                        $checkNextCourse = false;
                    } elseif ($nextCourseLesson) {
                        $isCompleted = LessonStatus::where('lesson_id',
                            $nextCourseLastLessonUnlocked->lesson_id)->where('student_id',
                            $this->student->getKey())->where('is_completed', true)->first();
                        if ($isCompleted) {
                            LessonStatus::updateOrCreate([
                                'lesson_id' => $nextCourseLesson['id'],
                                'student_id' => $this->student->getKey(),
                            ], [
                                'lesson_id' => $nextCourseLesson['id'],
                                'student_id' => $this->student->getKey(),
                                'is_unlocked' => 1,
                            ]);
                        }
                        $checkNextCourse = false;
                    } else {
                        $nextCourse = Course::where('id', '>', $nextCourse->getKey())->first();
                    }
                }
            }
            $noOfCoursesCompleted = CourseProgress::where('student_id', $this->student->getKey())->where('status',
                CourseProgress::STATUS['completed'])->count();

            if (array_key_exists($noOfCoursesCompleted, Certificate::AWARDED_AT)) {

                $certificate = Certificate::updateOrCreate([
                    'student_id' => $this->student->getKey(),
                    'level' => Certificate::LEVELS[Certificate::AWARDED_AT[$noOfCoursesCompleted]],
                ], [
                    'student_id' => $this->student->getKey(),
                    'level' => Certificate::LEVELS[Certificate::AWARDED_AT[$noOfCoursesCompleted]],
                    'teacher_id' => $teacherId,
                ]);
                $certificateAssigned = true;
            }
            $courseComplete = true;
        }
        if ($courseComplete) {
            $message = 'You have completed "'.$this->course->title.'" course successfully.';
            $this->student->notify(new CourseCompleteNotification($this->course));
            dispatch(new SMSNotifications($this->student, $message));
        }

        if ($certificateAssigned) {
            // Certificate Generation and notification
            dispatch(new CertificateGeneration($certificate));
            dispatch(new SMSNotifications($this->student, $message));
        }
    }
}
