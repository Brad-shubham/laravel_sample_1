<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\TestSubmit;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Lesson;
use App\Models\LessonStatus;
use App\Models\Test;
use App\Models\TestAnswer;
use App\Models\TestProgress;
use App\Models\TestQuestion;
use App\Models\TestQuestionOption;
use App\Models\TestResult;
use App\Models\User;
use App\Models\UsersProfile;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class TestController extends Controller
{
    /**
     * return the specified test details.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function test($id)
    {
        try {
            $student_id = Auth::user()->id;

            $tests = Test::with([
                'testProgress' => function ($query) use ($student_id) {
                    $query->where('student_id', $student_id);
                }
            ])->with([
                'questions.options', 'testResult' => function ($query) use ($student_id) {
                    $query->where('student_id', $student_id);
                }
            ])->whereId($id)->first();


            $i = 0;
            if ($tests->testResult) {
                $result_id = $tests->testResult->id;

                $submitted = TestAnswer::whereTestResultId($result_id)->first('submitted_answers');
                $original_answer = TestAnswer::whereTestResultId($result_id)->first('original_answers');
                $answer = collect(json_decode(json_encode($submitted->submitted_answers)));
                $original = collect(json_decode(json_encode($original_answer->original_answers)));
                $checkArray = $answer->toArray();

                foreach ($original['questions'] as $value) {
                    $ansArr['text'] = $value->text;
                    $ansArr['type'] = $answer['questions'][$i]->type;
                    $ansArr['answer'] = $answer['questions'][$i]->answer;

                    foreach ($checkArray['questions'] as $key => $item) {

                        if (array_key_exists("comments", $item)) {
                            $ansArr['feedback'] = $checkArray['questions'][$i]->comments;
                        }else{
                            $ansArr['feedback'] = null;
                        }
                    }

                    $tests['questions'][$i]['answer'] = $ansArr;
                    $i++;
                }
            } else {
                $result_id = null;
                $rows = count($tests->questions);

                for ($j = 0; $j < $rows; $j++) {
                    $tests['questions'][$j]['answer'] = null;
                }

            }

            foreach ($tests->questions as $test) {

                if ($test->type == 2) {
                    unset($test->options);
                }
            }

            $data['test_question'] = $tests;

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);

        }
    }

    /**
     * Primary test submission api
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     */

    public function testAnswer(Request $request)
    {

        try {

            $jsonData = $request->json()->all();

            if (!empty($jsonData)) {

                $testId = $jsonData[0]['test_id'];
                $submitted_answer = ['test_id' => $testId, 'questions' => []];
                $test = Test::with('questions', 'questions.options')->where('id', $testId)->first();
                $total_questions = $test->questions->count();
                $total_score = 0;

                foreach ($jsonData as $value) {
                    $question_type = TestQuestion::where('id', $value['question_id'])->first('type');
                    if ($question_type->type == TestQuestion::QUESTION_TYPE['MCQ']) {
                        $option_id = array_key_exists('answer', $value) ? $value['answer'] : 0;
                        $qns_id = array_key_exists('question_id', $value) ? $value['question_id'] : 0;


                        $result = TestQuestionOption::where('question_id', $qns_id)->where('id',
                            $option_id)->first('is_answer');
                        $is_answer = is_null($result) ? 0 : $result->is_answer;


                        if ($is_answer == 1) {
                            $marks = 10;
                        } else {
                            $marks = 0;
                        }

                        array_push($submitted_answer['questions'], [
                            'type' => intval($value['type']),
                            'score' => $marks,
                            'answer' => intval($option_id),
                            'comments' => null
                        ]);

                        $total_score = $total_score + $marks;
                    } else {

                        array_push($submitted_answer['questions'], [
                            'type' => intval($value['type']),
                            'answer' => $value['answer'],
                            'score' => 0,
                            'comments' => null
                        ]);

                    }

                }

                $checkTestResult = TestResult::where('test_id', $testId)->where('student_id', Auth::user()->id)->first();

                if (is_null($checkTestResult)){

                    DB::beginTransaction();

                    $testResult = TestResult::updateOrCreate([
                        'student_id' => Auth::user()->id,
                        'test_id' => $testId
                    ], [
                        'student_id' => Auth::user()->id,
                        'test_id' => $testId,
                        'total_marks' => $total_score,
                        'total_questions' => $total_questions,
                        'percentage' => 0,
                        'status' => TestResult::STATUS['pending']
                    ]);

                    $testAnswer = TestAnswer::updateOrCreate(['test_result_id' => $testResult->id,], [
                        'test_result_id' => $testResult->id,
                        'submitted_answers' => $submitted_answer,
                        'original_answers' => $test,
                    ]);

                    DB::commit();

                    if ($testAnswer) {

                        UsersProfile::updateOrCreate([
                            'user_id' => Auth::user()->id,
                        ],[
                            'last_test' => Carbon::now(),
                        ]);

                        $test = Test::where('id', $testId)->first();
                        $lessonId = $test->lesson_id;

                        $courseValue = Course::whereHas('books.lessons', function ($query) use ($lessonId) {
                            $query->where('id', $lessonId);
                        })->first();

                        $course = Course::with('books.lessons')->where('id', $courseValue->id)->first();
                        $courseLesson = $course->lessons()->get()->toArray();

                        $lessonArray = [];
                        $completedLessonArray = [];
                        $nextLessonId = '';

                        foreach ($courseLesson as $lesson) {
                            $getLessonId = LessonStatus::where('lesson_id', $lesson['id'])->where('student_id',
                                Auth::user()->id)->where('is_complete', 1)->first();
                            $lessonArray[]['lesson_id'] = $lesson['id'];

                            if ($getLessonId == null) {
                                $nextLessonId = $lesson['id'];
                                break;
                            } else {
                                $completedLessonArray[]['lesson_id'] = $lesson['id'];
                            }
                        }

                        if ($nextLessonId != '') {
                            $checkLesson = Lesson::where('id', $nextLessonId)->first();

                            if ($checkLesson != null) {
                                LessonStatus::updateOrCreate([
                                    'lesson_id' => $nextLessonId,
                                    'student_id' => Auth::user()->id,
                                ], [
                                    'lesson_id' => $nextLessonId,
                                    'student_id' => Auth::user()->id,
                                    'is_unlocked' => 1
                                ]);
                            }
                        } else {
                            LessonStatus::updateOrCreate([
                                'lesson_id' => $lessonId,
                                'student_id' => Auth::user()->id,
                            ],
                                [
                                    'lesson_id' => $lessonId,
                                    'student_id' => Auth::user()->id,
                                    'is_complete' => 1
                                ]);

                        }

                        if ($lessonArray === $completedLessonArray){

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
                        $test = Test::where('id', $testId)->first();
                        $studentUser = User::where('id', Auth::user()->id)->first();
                        Mail::send(new TestSubmit($studentUser, $test));
                        return response()->json(['msg'=>"Your Answer is Submitted Successfully"], 200);

                    }else{
                        return response()->json(['error'=>"Something Went Wrong"], 403);

                    }

                }else{
                    DB::beginTransaction();
                    $testResult = TestResult::updateOrCreate([
                        'student_id' => Auth::user()->id,
                        'test_id' => $testId
                    ], [
                        'total_marks' => $total_score,
                        'total_questions' => $total_questions,
                        'percentage' => 0,
                        'status' => TestResult::STATUS['pending']
                    ]);

                    TestAnswer::updateOrCreate(['test_result_id' => $testResult->id,], [
                        'test_result_id' => $testResult->id,
                        'submitted_answers' => $submitted_answer,
                        'original_answers' => $test,
                    ]);
                    $test = Test::where('id', $testId)->first();
                    $studentUser = User::where('id', Auth::user()->id)->first();

                    DB::commit();
                    Mail::send(new TestSubmit($studentUser, $test));
                    return response()->json(['msg'=>"Your Answer is Submitted Successfully"], 200);
                }

            } else {
                $error["error_msg"] = "Please, Submit valid json data!";

                return response()->json($error);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }

    }
}
