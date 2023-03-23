<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\CertificateGeneration;
use App\Jobs\SMSNotifications;
use App\Models\Book;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Lesson;
use App\Models\LessonStatus;
use App\Models\Paragraph;
use App\Models\ParagraphQuestionsAnswer;
use App\Models\Test;
use App\Models\TestProgress;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Models\User;
use App\Models\UsersProfile;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CourseCompleteNotification;

class ParagraphController extends Controller
{
    /**
     * This function return the paragraph details.
     * @param  $id
     * @return JsonResponse
     */
    public function paragraph($id){
        try
        {
            $para = Paragraph::where('id', $id)->with('questions')->first();

            return response()->json($para);

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * paragraph question answer submission api
     *
     * @param Request $request
     * @return JsonResponse
     *
     */

    public function paragraphAnswer(Request $request)
    {
        $jsonData = $request->json()->all();

        try
        {
            $question_id= $jsonData["question_id"];
            $answer = $jsonData["answer"];

            $paraResult = ParagraphQuestionsAnswer::updateOrCreate([
                'user_id' => Auth::user()->id,
                'question_id'=> $question_id
            ],[
                'user_id' => Auth::user()->id,
                'question_id'=> $question_id,
                'answer' => $answer,
            ]);


            if ($paraResult){

                UsersProfile::updateOrCreate([
                    'user_id' => Auth::user()->id,
                ],[
                    'last_test' => Carbon::now(),
                ]);

                $lesson = Lesson::whereHas('paragraphs.questions', function ($query) use ($question_id){
                    $query->where('id', $question_id);
                })->first();

                $lesson_id = $lesson->id;

                $getLesson = Lesson::with('paragraphs.questions')->where('id',$lesson_id)->first();

                $numberOfLessonQuestions = $getLesson->paraQuestions()->count();
                $numberOfLessonQuestionsAnswer = $getLesson->paragraphAnswers()->where('user_id', Auth::user()->id)->count();


                if ($numberOfLessonQuestions == $numberOfLessonQuestionsAnswer)
                {
                        LessonStatus::updateOrCreate([
                           'lesson_id' => $lesson_id,
                           'student_id' => Auth::user()->id
                       ],[
                        'lesson_id' => $lesson_id,
                        'student_id' => Auth::user()->id,
                        'is_complete' => 1
                    ]);
                    UsersProfile::whereUserId(Auth::user()->id)->update([
                        'activity_status' => 'active',
                    ]);

                    $course = Course::with('books.lessons')->first();
                    $firstLesson = $course->lessons()->first();
                    $checkFirstLessonId = $firstLesson->id;

                    if ($checkFirstLessonId == $lesson_id)
                    {
                       $checkTest = Test::where('lesson_id', $lesson_id)->first();

                       if ($checkTest != null){
                           $checkTestStatus = TestProgress::where('test_id', $checkTest->id)->where('student_id', Auth::user()->id)->where('is_unlocked', 1)->first();

                           if ($checkTestStatus == null){

                               TestProgress::updateOrCreate([
                                   'test_id' => $checkTest->id,
                                   'student_id' => Auth::user()->id,
                               ],
                                   [
                                       'test_id' => $checkTest->id,
                                       'student_id' => Auth::user()->id,
                                       'is_unlocked' => 1
                                   ]);
                           }
                       }else{

                           $courseValue = Course::whereHas('books.lessons', function ($query) use ($lesson_id){
                               $query->where('id', $lesson_id);
                           })->first();

                           $course = Course::with('books.lessons')->where('id', $courseValue->id)->first();
                           $courseLesson = $course->lessons()->get()->toArray();

                           $lessonArray = [];
                           $completedLessonArray = [];
                           $nextLessonId = '';

                           foreach ($courseLesson as $lesson){
                               $getLessonId = LessonStatus::where('lesson_id', $lesson['id'])->where('student_id', Auth::user()->id)->where('is_complete', 1)->first();
                               $lessonArray[]['lesson_id'] = $lesson['id'];

                               if ($getLessonId == null){
                                   $nextLessonId = $lesson['id']; break;
                               }else{
                                   $completedLessonArray[]['lesson_id'] = $lesson['id'];
                               }
                           }

                           if ($nextLessonId !=''){
                               $checkLesson = Lesson::where('id', $nextLessonId)->first();

                               if ($checkLesson != null){
                                   LessonStatus::updateOrCreate([
                                       'lesson_id' => $nextLessonId,
                                       'student_id' => Auth::user()->id,
                                   ],[
                                       'lesson_id' => $nextLessonId,
                                       'student_id' => Auth::user()->id,
                                       'is_unlocked' => 1
                                   ]);
                               }
                           }else{
                               LessonStatus::updateOrCreate([
                                   'lesson_id' => $lesson_id,
                                   'student_id' => Auth::user()->id,
                               ],
                                   [
                                       'lesson_id' => $lesson_id,
                                       'student_id' => Auth::user()->id,
                                       'is_complete' => 1
                                   ]);
                               UsersProfile::whereUserId(Auth::user()->id)->update([
                                   'activity_status' => 'active',
                               ]);
                           }

                           if ($lessonArray === $completedLessonArray){

                               $courses = Course::all();
                               $nextCourseId = '';
                               foreach ($courses as $course){
                                   $checkCourseComplete = CourseProgress::where('course_id', $course['id'])->where('student_id', Auth::user()->id)->where('status', 3)->first();
                                   if ($checkCourseComplete == null){
                                       $nextCourseId = $course->id; break;
                                   }

                               }
                               if ($nextCourseId !=''){

                                   CourseProgress::updateorCreate([
                                       'course_id' => $nextCourseId,
                                       'student_id' => Auth::user()->id
                                   ],[
                                       'course_id' => $nextCourseId,
                                       'student_id' => Auth::user()->id,
                                       'status' => 1
                                   ]);

                                   $course = Course::with('books.lessons')->where('id', $nextCourseId)->first();
                                   $courseLesson = $course->lessons()->get()->toArray();
                                   $getFirstLesson = current($courseLesson);
                                   $getLessonId = $getFirstLesson['id'];

                                   LessonStatus::updateOrCreate([
                                       'lesson_id' => $getLessonId,
                                       'student_id' => Auth::user()->id,
                                   ],[
                                       'lesson_id' => $getLessonId,
                                       'student_id' => Auth::user()->id,
                                       'is_unlocked' => 1
                                   ]);
                               }else{

                                   CourseProgress::updateorcreate([
                                       'course_id' => $courseValue->id,
                                       'student_id' => Auth::user()->id
                                   ],[
                                       'course_id' => $courseValue->id,
                                       'student_id' => Auth::user()->id,
                                       'status' => 3
                                   ]);

                                   //Update Gift Sent status
                                   $numberOfCoursesCompleted = User::where('id', Auth::user()->id)
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
                                           'course_id' => $courseValue->id,
                                           'student_id' => Auth::user()->id,
                                       ], [
                                           'course_id' => $courseValue->id,
                                           'student_id' => Auth::user()->id,
                                           'gift_status' => true,
                                       ]);
                                   }
                               }

                           }else{
                               CourseProgress::updateorcreate([
                                   'course_id' => $courseValue->id,
                                   'student_id' => Auth::user()->id
                               ],[
                                   'course_id' => $courseValue->id,
                                   'student_id' => Auth::user()->id,
                                   'status' => 1
                               ]);
                           }

                       }
                    }
                    else
                    {
                        $courseAll = Course::with('books.lessons')->get();

                        $data = array();
                        $flag = false;
                        foreach ($courseAll as $course){
                            foreach ($course->books as $book){
                                foreach ($book->lessons as $lesson ){
                                    array_push($data,$lesson->id);
                                    if ($lesson_id == $lesson->id){
                                        $flag = true;
                                        break;
                                    }
                                }
                                if($flag){
                                    break;
                                }
                            }
                            if($flag){
                                break;
                            }
                        }

                        $index = array_search($lesson_id, $data);
                        if($index != 0 ){
                            $index = $index - 1;
                        }

                        $previousLessonId = $data[$index];

                        $checkTest = Test::where('lesson_id', $previousLessonId)->first();

                        if ($checkTest != null){

                            $checkTestQualification = TestResult::where('test_id', $checkTest->id)->where('status', 2)->where('student_id', Auth::user()->id)->first();

                            if ($checkTestQualification != null){

                                $checkCurrentLessonTest = Test::where('lesson_id', $lesson_id)->first();

                                if ($checkCurrentLessonTest != null){

                                    TestProgress::updateOrCreate([
                                        'test_id' => $checkCurrentLessonTest->id,
                                        'student_id' => Auth::user()->id,
                                    ],
                                        [
                                            'test_id' => $checkCurrentLessonTest->id,
                                            'student_id' => Auth::user()->id,
                                            'is_unlocked' => 1
                                        ]);
                                }else{

                                    $courseValue = Course::whereHas('books.lessons', function ($query) use ($lesson_id){
                                        $query->where('id', $lesson_id);
                                    })->first();

                                    $course = Course::with('books.lessons')->where('id', $courseValue->id)->first();
                                    $courseLesson = $course->lessons()->get()->toArray();

                                    $lessonArray = [];
                                    $completedLessonArray = [];
                                    $nextLessonId = '';

                                    foreach ($courseLesson as $lesson){
                                        $getLessonId = LessonStatus::where('lesson_id', $lesson['id'])->where('student_id', Auth::user()->id)->where('is_complete', 1)->first();
                                        $lessonArray[]['lesson_id'] = $lesson['id'];

                                        if ($getLessonId == null){
                                            $nextLessonId = $lesson['id']; break;
                                        }else{
                                            $completedLessonArray[]['lesson_id'] = $lesson['id'];
                                        }
                                    }

                                    if ($nextLessonId !=''){
                                        $checkLesson = Lesson::where('id', $nextLessonId)->first();

                                        if ($checkLesson != null){
                                            LessonStatus::updateOrCreate([
                                                'lesson_id' => $nextLessonId,
                                                'student_id' => Auth::user()->id,
                                            ],[
                                                'lesson_id' => $nextLessonId,
                                                'student_id' => Auth::user()->id,
                                                'is_unlocked' => 1
                                            ]);
                                        }
                                    }else{
                                        LessonStatus::updateOrCreate([
                                            'lesson_id' => $lesson_id,
                                            'student_id' => Auth::user()->id,
                                        ],
                                            [
                                                'lesson_id' => $lesson_id,
                                                'student_id' => Auth::user()->id,
                                                'is_complete' => 1
                                            ]);
                                        UsersProfile::whereUserId(Auth::user()->id)->update([
                                            'activity_status' => 'active',
                                        ]);
                                    }

                                    if ($lessonArray === $completedLessonArray){

                                        // Get the average score of the course

                                        $courseTotalMarks = $course->testResults()->where('status', TestResult::STATUS['qualified'])->where('student_id', Auth::user()->id)->sum('total_marks');
                                        $noOfTestResults  = $course->testResults()->where('student_id', Auth::user()->id)->get();
                                        $totalTestMarks = $noOfTestResults->sum('total_questions') * TestQuestion::MAX_MARKS;

                                        if ($totalTestMarks != 0 ){
                                            $averageScore = ($courseTotalMarks / $totalTestMarks) * 100;
                                        }else{
                                            $averageScore = 0;
                                        }

                                        $courseComplete = CourseProgress::updateorCreate([
                                            'course_id' => $courseValue->id,
                                            'student_id' => Auth::user()->id
                                        ],[
                                            'average_score' => number_format($averageScore, 2),
                                            'status' => 3
                                        ]);

                                        $noOfCoursesCompleted = CourseProgress::where('student_id', Auth::user()->id)->where('status', CourseProgress::STATUS['completed'])->count();

                                        if (array_key_exists($noOfCoursesCompleted, Certificate::AWARDED_AT)){

                                            $certificate = Certificate::updateorCreate([
                                                'student_id' => Auth::user()->id,
                                                'level' => Certificate::LEVELS[Certificate::AWARDED_AT[$noOfCoursesCompleted]],
                                            ],[
                                                'student_id' => Auth::user()->id,
                                                'level' => Certificate::LEVELS[Certificate::AWARDED_AT[$noOfCoursesCompleted]],
                                                'teacher_id' => $noOfTestResults[0]->teacher_id,

                                            ]);

                                            if ($certificate){
                                                // Certificate Generation and notification
                                                $this->dispatch(new CertificateGeneration($certificate));
                                            }
                                        }

                                        if ($courseComplete){
                                            $student = User::where('id', Auth::user()->id)->first();
                                            $message = 'You have completed "'.$courseValue->title.'" course successfully.';
                                            $student->notify(new CourseCompleteNotification($courseValue));
//                                            $this->dispatch(new SMSNotifications($student, $message));
                                        }

                                        CourseProgress::updateorcreate([
                                            'course_id' => $courseValue->id,
                                            'student_id' => Auth::user()->id
                                        ],[
                                            'course_id' => $courseValue->id,
                                            'student_id' => Auth::user()->id,
                                            'status' => 3
                                        ]);

                                        //Update Gift Sent status
                                        $numberOfCoursesCompleted = User::where('id', Auth::user()->id)
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
                                                'course_id' => $courseValue->id,
                                                'student_id' => Auth::user()->id,
                                            ], [
                                                'course_id' => $courseValue->id,
                                                'student_id' => Auth::user()->id,
                                                'gift_status' => true,
                                            ]);
                                        }

                                        $courses = Course::all();
                                        $nextCourseId = '';
                                        foreach ($courses as $course){
                                            $checkCourseComplete = CourseProgress::where('course_id', $course['id'])->where('student_id', Auth::user()->id)->where('status', 3)->first();
                                            if ($checkCourseComplete == null){
                                                $nextCourseId = $course->id; break;
                                            }

                                        }
                                        if ($nextCourseId !=''){

                                            CourseProgress::updateorcreate([
                                                'course_id' => $nextCourseId,
                                                'student_id' => Auth::user()->id
                                            ],[
                                                'course_id' => $nextCourseId,
                                                'student_id' => Auth::user()->id,
                                                'status' => 1
                                            ]);

                                            $course = Course::with('books.lessons')->where('id', $nextCourseId)->first();
                                            $courseLesson = $course->lessons()->get()->toArray();
                                            $getFirstLesson = current($courseLesson);
                                            $getLessonId = $getFirstLesson['id'];

                                            LessonStatus::updateOrCreate([
                                                'lesson_id' => $getLessonId,
                                                'student_id' => Auth::user()->id,
                                            ],[
                                                'lesson_id' => $getLessonId,
                                                'student_id' => Auth::user()->id,
                                                'is_unlocked' => 1
                                            ]);
                                        }else{

                                            CourseProgress::updateorcreate([
                                                'course_id' => $courseValue->id,
                                                'student_id' => Auth::user()->id
                                            ],[
                                                'course_id' => $courseValue->id,
                                                'student_id' => Auth::user()->id,
                                                'status' => 3
                                            ]);
                                        }

                                    }else{
                                        CourseProgress::updateorcreate([
                                            'course_id' => $courseValue->id,
                                            'student_id' => Auth::user()->id
                                        ],[
                                            'course_id' => $courseValue->id,
                                            'student_id' => Auth::user()->id,
                                            'status' => 1
                                        ]);
                                    }

                                }
                            }

                        }else{

                            $checkCurrentLessonTest = Test::where('lesson_id', $lesson_id)->first();

                            if ($checkCurrentLessonTest != null){

                                TestProgress::updateOrCreate([
                                    'test_id' => $checkCurrentLessonTest->id,
                                    'student_id' => Auth::user()->id,
                                ],
                                    [
                                        'test_id' => $checkCurrentLessonTest->id,
                                        'student_id' => Auth::user()->id,
                                        'is_unlocked' => 1
                                    ]);

                            }else{

                                $courseValue = Course::whereHas('books.lessons', function ($query) use ($lesson_id){
                                    $query->where('id', $lesson_id);
                                })->first();

                                $course = Course::with('books.lessons')->where('id', $courseValue->id)->first();
                                $courseLesson = $course->lessons()->get()->toArray();

                                $lessonArray = [];
                                $completedLessonArray = [];
                                $nextLessonId = '';

                                foreach ($courseLesson as $lesson){
                                    $getLessonId = LessonStatus::where('lesson_id', $lesson['id'])->where('student_id', Auth::user()->id)->where('is_complete', 1)->first();
                                    $lessonArray[]['lesson_id'] = $lesson['id'];

                                    if ($getLessonId == null){
                                        $nextLessonId = $lesson['id']; break;
                                    }else{
                                        $completedLessonArray[]['lesson_id'] = $lesson['id'];
                                    }
                                }

                                if ($nextLessonId !=''){
                                    $checkLesson = Lesson::where('id', $nextLessonId)->first();

                                    if ($checkLesson != null){
                                        LessonStatus::updateOrCreate([
                                            'lesson_id' => $nextLessonId,
                                            'student_id' => Auth::user()->id,
                                        ],[
                                            'lesson_id' => $nextLessonId,
                                            'student_id' => Auth::user()->id,
                                            'is_unlocked' => 1
                                        ]);
                                    }
                                }else{
                                    LessonStatus::updateOrCreate([
                                        'lesson_id' => $lesson_id,
                                        'student_id' => Auth::user()->id,
                                    ],
                                        [
                                            'lesson_id' => $lesson_id,
                                            'student_id' => Auth::user()->id,
                                            'is_complete' => 1
                                        ]);
                                    UsersProfile::whereUserId(Auth::user()->id)->update([
                                        'activity_status' => 'active',
                                    ]);
                                }

                                if ($lessonArray === $completedLessonArray){

                                    // Get the average score of the course

                                    $courseTotalMarks = $course->testResults()->where('status', TestResult::STATUS['qualified'])->where('student_id', Auth::user()->id)->sum('total_marks');
                                    $noOfTestResults  = $course->testResults()->where('student_id', Auth::user()->id)->get();
                                    $totalTestMarks = $noOfTestResults->sum('total_questions') * TestQuestion::MAX_MARKS;

                                    if ($totalTestMarks != 0 ){
                                        $averageScore = ($courseTotalMarks / $totalTestMarks) * 100;
                                    }else{
                                        $averageScore = 0;
                                    }

                                    $courseComplete = CourseProgress::updateorCreate([
                                        'course_id' => $courseValue->id,
                                        'student_id' => Auth::user()->id
                                    ],[
                                        'average_score' => number_format($averageScore, 2),
                                        'status' => 3
                                    ]);


                                    $noOfCoursesCompleted = CourseProgress::where('student_id', Auth::user()->id)->where('status', CourseProgress::STATUS['completed'])->count();

                                    if (array_key_exists($noOfCoursesCompleted, Certificate::AWARDED_AT)){

                                        $certificate = Certificate::updateorCreate([
                                            'student_id' => Auth::user()->id,
                                            'level' => Certificate::LEVELS[Certificate::AWARDED_AT[$noOfCoursesCompleted]],
                                        ],[
                                            'student_id' => Auth::user()->id,
                                            'level' => Certificate::LEVELS[Certificate::AWARDED_AT[$noOfCoursesCompleted]],
                                            'teacher_id' => $noOfTestResults[0]->teacher_id,

                                        ]);

                                        if ($certificate){
                                            // Certificate Generation and notification
                                            $this->dispatch(new CertificateGeneration($certificate));
                                        }
                                    }

                                    if ($courseComplete){
                                        $student = User::where('id', Auth::user()->id)->first();
                                        $message = 'You have completed "'.$courseValue->title.'" course successfully.';
                                        $student->notify(new CourseCompleteNotification($courseValue));
//                                        $this->dispatch(new SMSNotifications($student, $message));
                                    }

                                    CourseProgress::updateorcreate([
                                        'course_id' => $courseValue->id,
                                        'student_id' => Auth::user()->id
                                    ],[
                                        'course_id' => $courseValue->id,
                                        'student_id' => Auth::user()->id,
                                        'status' => 3
                                    ]);

                                    //Update Gift Sent status
                                    $numberOfCoursesCompleted = User::where('id', Auth::user()->id)
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
                                            'course_id' => $courseValue->id,
                                            'student_id' => Auth::user()->id,
                                        ], [
                                            'course_id' => $courseValue->id,
                                            'student_id' => Auth::user()->id,
                                            'gift_status' => true,
                                        ]);
                                    }


                                    $courses = Course::all();
                                    $nextCourseId = '';
                                    foreach ($courses as $course){
                                        $checkCourseComplete = CourseProgress::where('course_id', $course['id'])->where('student_id', Auth::user()->id)->where('status', 3)->first();
                                        if ($checkCourseComplete == null){
                                            $nextCourseId = $course->id; break;
                                        }

                                    }
                                    if ($nextCourseId !=''){

                                        CourseProgress::updateorcreate([
                                            'course_id' => $nextCourseId,
                                            'student_id' => Auth::user()->id
                                        ],[
                                            'course_id' => $nextCourseId,
                                            'student_id' => Auth::user()->id,
                                            'status' => 1
                                        ]);

                                        $course = Course::with('books.lessons')->where('id', $nextCourseId)->first();
                                        $courseLesson = $course->lessons()->get()->toArray();
                                        $getFirstLesson = current($courseLesson);
                                        $getLessonId = $getFirstLesson['id'];

                                        LessonStatus::updateOrCreate([
                                            'lesson_id' => $getLessonId,
                                            'student_id' => Auth::user()->id,
                                        ],[
                                            'lesson_id' => $getLessonId,
                                            'student_id' => Auth::user()->id,
                                            'is_unlocked' => 1
                                        ]);
                                    }else{

                                        CourseProgress::updateorcreate([
                                            'course_id' => $courseValue->id,
                                            'student_id' => Auth::user()->id
                                        ],[
                                            'course_id' => $courseValue->id,
                                            'student_id' => Auth::user()->id,
                                            'status' => 3
                                        ]);
                                    }

                                }else{
                                    CourseProgress::updateorcreate([
                                        'course_id' => $courseValue->id,
                                        'student_id' => Auth::user()->id
                                    ],[
                                        'course_id' => $courseValue->id,
                                        'student_id' => Auth::user()->id,
                                        'status' => 1
                                    ]);
                                }

                            }

                        }

                    }
                }
                else
                {
                    LessonStatus::updateOrCreate([
                        'lesson_id' => $lesson_id,
                        'student_id' => Auth::user()->id
                    ], [
                        'lesson_id' => $lesson_id,
                        'student_id' => Auth::user()->id,
                        'is_completed' => 0
                    ]);
                    UsersProfile::whereUserId(Auth::user()->id)->update([
                        'activity_status' => 'active',
                    ]);
                }
                $success['message'] = "Your Answer Submitted Successfully";
                return response()->json($success, 200);
            }else{
                $error['error'] = "Something Went Wrong";
                return response()->json($error, 403);
            }

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
