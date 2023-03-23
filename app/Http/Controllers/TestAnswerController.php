<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestAnswer\UpdateRequest;
use App\Jobs\CourseTestAnswerEvaluation;
use App\Jobs\SMSNotifications;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Test;
use App\Models\TestAnswer;
use App\Models\TestResult;
use App\Models\User;
use App\Notifications\TestCommentsNotification;
use App\Notifications\TestCompleteNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TestAnswerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('testResults.index');
    }

    /**
     * Returns the test answer data for listing
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTestAnswerData(Request $request)
    {
        $sortByColumn = 'status';
        $sortOrder = 'asc';
        $length = 10;
        $searchValue = '';

        if ($request->filled(['length'])) {
            $length = $request->input('length');
        }

        if ($request->filled(['dir'])) {
            $sortOrder = $request->input('dir');
        }

        if ($request->filled(['column'])) {
            $sortByColumn = $request->input('column');
        }

        if ($request->filled(['search'])) {
            $searchValue = $request->input('search');
        }

        $testResult = TestResult::with('student', 'answer', 'test')
            ->where(function ($query) use ($searchValue) {
                $query->whereHas('student.profile', function ($query) use ($searchValue) {
                    return $query->where("first_name", "LIKE", "%{$searchValue}%")
                        ->orWhere("last_name", "LIKE", "%{$searchValue}%");
                })
                    ->orWhereHas('test', function ($query) use ($searchValue) {
                        $query->where("title", "LIKE", "%{$searchValue}%");
                    });
            })
            ->orderBy($sortByColumn, $sortOrder)
            ->orderBy('created_at', 'desc')
            ->paginate($length);

        if ($request->expectsJson()) {
            return response()->json(['testAnswers' => $testResult], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TestResult  $testAnswer
     * @return View
     */
    public function edit(TestResult $testAnswer)
    {
        $testAnswer->load('student', 'answer');

        return view('testResults.edit', compact('testAnswer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  TestResult  $testAnswer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, TestResult $testAnswer)
    {
        /**
         * @var Test $test
         */
        $test = Test::withTrashed()->find($testAnswer->test_id);
        /**
         * @var User $student
         */
        $student = User::find($testAnswer->student_id);
        /**
         * @var Course $course
         */
        $course = $testAnswer->course;

        DB::beginTransaction();

        $teacherId = Auth::user()->id;

        $status = ($request->get('percentage') < TestResult::PASSING_PERCENTAGE) ? TestResult::STATUS['not_qualified'] : TestResult::STATUS['qualified'];

        $testAnswer->update(array_merge($request->only('total_marks', 'percentage'),
            ['teacher_id' => $teacherId, 'status' => $status]));

        $testResult = TestAnswer::updateOrCreate([
            'test_result_id' => $testAnswer->id,
        ], $request->only('submitted_answers'));

        CourseProgress::updateOrCreate([
            'course_id' => $course->getKey(),
            'student_id' => $student->getKey(),
        ], [
            'course_id' => $course->getKey(),
            'student_id' => $student->getKey(),
            'status' => CourseProgress::STATUS['progress'],
        ]);

        DB::commit();

        if ($status === TestResult::STATUS['qualified']) {
            $message = 'You have qualified the "'.$test->title.'" test.';

            /**
             * Update the status of the course, lesson and test according to the evaluation
             */
            $this->dispatch(new CourseTestAnswerEvaluation($student, $course, $message));
        } else {
            $message = 'You are not able to qualified the "'.$test->title.'" test.';
        }

        $student->notify(new TestCompleteNotification($test, $message));
        // SMS Notification
        $this->dispatch(new SMSNotifications($student, $message));

        if ($request->get('has_comments')) {
            $student->notify(new TestCommentsNotification($test));
            // SMS Notification
            $message = 'There are some feedbacks from teacher on '.$test->title.' test.';
            $this->dispatch(new SMSNotifications($student, $message));
        }

        return response()->json([
            'status' => true,
        ]);

    }
}
