<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\CreateRequest;
use App\Http\Requests\Test\OfflineTestEntryRequest;
use App\Http\Requests\Test\UpdateRequest;
use App\Jobs\OfflineTestAnswerEvaluation;
use App\Models\CourseProgress;
use App\Models\Lesson;
use App\Models\LessonStatus;
use App\Models\Test;
use App\Models\TestProgress;
use App\Models\TestQuestion;
use App\Models\TestQuestionOption;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('tests.index');
    }

    /**
     * Returns the tests data for listing
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTestData(Request $request)
    {
        $sortByColumn = 'id';
        $sortOrder = 'desc';
        $length = '10';
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


        $tests = Test::withCount('questions')
            ->where(function ($query) use ($searchValue) {
                $query->where("title", "LIKE", "%{$searchValue}%")
                    ->orWhereHas('lesson', function ($query) use ($searchValue) {
                        return $query->where("name", "LIKE", "%{$searchValue}%");
                    });
            })
            ->orderBy($sortByColumn, $sortOrder)
            ->paginate($length);

        if ($request->expectsJson()) {
            return response()->json(['tests' => $tests], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lessons = Lesson::whereDoesntHave('test')->get();
        $questionType = TestQuestion::QUESTION_TYPE;

        return view('tests.create', compact('lessons', 'questionType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request)
    {
        DB::beginTransaction();

        $test = Test::create($request->only(['title', 'lesson_id']));

        $questions = $request->get('questions');

        foreach ($questions as $question) {
            $testQuestion = TestQuestion::create([
                'text' => $question['text'],
                'type' => $question['type'],
                'test_id' => $test->id,
            ]);

            if ($question['type'] === TestQuestion::QUESTION_TYPE['MCQ']) {
                $options = $question['options'];
                foreach ($options as $option) {
                    $testOption = TestQuestionOption::create(array_merge($option, [
                        'question_id' => $testQuestion->id,
                    ]));
                }
            }
        }

        DB::commit();

        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Test  $test
     * @return View
     */
    public function show(Test $test)
    {
        $questionType = TestQuestion::QUESTION_TYPE;
        $test->load('questions', 'questions.options');

        return view('tests.view', compact('test', 'questionType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Test  $test
     * @return View
     */
    public function edit(Test $test)
    {
        $lessons = Lesson::whereDoesntHave('test')->get();
        $questionType = TestQuestion::QUESTION_TYPE;

        $test->load(['questions', 'questions.options']);
        return view('tests.edit', compact('test', 'lessons', 'questionType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Test  $test
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Test $test)
    {
        DB::beginTransaction();

        $test->update($request->only('title', 'lesson_id'));

        $test->questions()->each(function ($question) {
            $question->options()->delete();
        });

        $test->questions()->delete();

        $questions = $request->get('questions');

        foreach ($questions as $question) {
            $testQuestion = TestQuestion::create([
                'text' => $question['text'],
                'type' => $question['type'],
                'test_id' => $test->id,
            ]);

            if ($question['type'] === TestQuestion::QUESTION_TYPE['MCQ']) {
                $options = $question['options'];
                foreach ($options as $option) {
                    TestQuestionOption::create(array_merge($option, [
                        'question_id' => $testQuestion->id,
                    ]));
                }
            }
        }

        DB::commit();

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Test  $test
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Test $test)
    {
        DB::beginTransaction();

        $test->questions()->each(function ($question) {
            $question->options()->delete();
        });
        $test->questions()->delete();
        $test->delete();

        DB::commit();

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Delete the question from the test.
     *
     * @param  Test  $test
     * @param  TestQuestion  $testQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteQuestion(Test $test, TestQuestion $testQuestion)
    {
        DB::beginTransaction();

        $testQuestion->options()->delete();
        $testQuestion->delete();

        DB::commit();

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Delete the option from the question.
     *
     * @param  Test  $test
     * @param  TestQuestion  $testQuestion
     * @param  TestQuestionOption  $testQuestionOption
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOption(Test $test, TestQuestion $testQuestion, TestQuestionOption $testQuestionOption)
    {
        DB::beginTransaction();

        $testQuestionOption->delete();

        DB::commit();

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function offlineTestEntry()
    {
        $tests = Test::all();
        $students = User::where('user_type', User::USER_TYPE['student'])->get();

        return view('tests.offlineTestEntry', compact('tests', 'students'));
    }

    public function saveOfflineTestEntry(OfflineTestEntryRequest $request)
    {
        $student = User::find($request->get('student_id'));
        $test = Test::find($request->get('test_id'));
        $grades = (float) $request->get('grades');
        $course = $test->lesson->course;

        $teacherId = Auth::user()->id;

        $totalMarks = $test->questions()->count() * TestQuestion::MAX_MARKS;
        $percentage = ($grades <= $totalMarks) ? round(($grades / $totalMarks) * 100, 2) : null;
        if ($percentage) {
            $status = ($percentage < TestResult::PASSING_PERCENTAGE) ? TestResult::STATUS['not_qualified'] : TestResult::STATUS['qualified'];
            DB::beginTransaction();

            TestResult::updateOrCreate([
                'student_id' => $student->getKey(),
                'test_id' => $test->getKey()
            ], [
                'total_marks' => $totalMarks,
                'total_questions' => $test->questions()->count(),
                'percentage' => $percentage,
                'status' => $status,
                'teacher_id' => $teacherId,
            ]);

            CourseProgress::updateOrCreate([
                'course_id' => $course->getKey(),
                'student_id' => $student->getKey(),
            ], [
                'course_id' => $course->getKey(),
                'student_id' => $student->getKey(),
                'status' => CourseProgress::STATUS['progress'],
            ]);

            if ($status === TestResult::STATUS['qualified']) {
                $message = 'You have qualified the "'.$test->title.'" test.';

                LessonStatus::updateOrCreate([
                    'lesson_id' => $test->lesson->getKey(),
                    'student_id' => $student->getKey(),
                ], [
                    'lesson_id' => $test->lesson->getKey(),
                    'student_id' => $student->getKey(),
                    'is_unlocked' => 1,
                    'is_complete' => 1,
                ]);

                TestProgress::updateOrCreate([
                    'test_id' => $test->getKey(),
                    'student_id' => $student->getKey(),
                ], [
                    'test_id' => $test->getKey(),
                    'student_id' => $student->getKey(),
                    'is_unlocked' => 1,
                ]);

                /**
                 * Update the status of the course, lesson and test according to the evaluation
                 */
                $this->dispatch(new OfflineTestAnswerEvaluation($student, $course, $message));
            }
            DB::commit();
        } else {
            return response()->json([
                'status' => false
            ]);
        }

        return response()->json([
            'status' => true
        ]);
    }
}
