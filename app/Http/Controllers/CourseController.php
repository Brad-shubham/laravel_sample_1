<?php

namespace App\Http\Controllers;

use App\Http\Requests\Courses\StoreCourseRequest;
use App\Http\Requests\Courses\UpdateCourseRequest;
use App\Models\Lesson;
use App\Models\Book;
use App\Models\Course;
use App\Models\Test;
use Couchbase\Exception;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class CourseController extends Controller
{
    /**
     * Returns view which contains list of courses
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('courses.list');
    }

    /**
     * Returns the courses data for listing
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourseData(Request $request)
    {
        $sortByColumn = 'courses.portal_course_id';
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


        $courses = Course::withCount('books')
            ->where("courses.name", "LIKE", "%$searchValue%")
            ->orderBy($sortByColumn, $sortOrder)
            ->paginate($length);

        if ($request->expectsJson()) {
            return response()->json($courses, 200);
        }
    }

    /**
     * Returns view to create a new course
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('courses.create');
    }

    /**
     *  Save a new course
     *
     * @param StoreCourseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCourseRequest $request)
    {
        DB::beginTransaction();

        $course = new Course($request->courseBaseData());
        $course->save();

        foreach ($request->input('books') as $bookData) {

            /**
             * @var Book $book
             */
            $book = $course->books()->create($request->bookBaseData($bookData));
            foreach ($bookData['lessons'] as $lessonData) {
                $book->lessons()->create($request->baseLessonData($lessonData));
            }
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Course created successfully.',
            'id' => $course->id,
        ]);
    }

    /**
     * @param Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Course $course)
    {
        $course->loadMissing('books.lessons');

        return view('courses.view', compact('course'));
    }

    /**
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $course->loadMissing('books.lessons');

        return \response()->view('courses.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
//        dd($request->portal_course_id);
        DB::beginTransaction();

        $course->name = $request->name;

        if ($course->isDirty('name')) {
            $course->save();
        }

        $course->portal_course_id = $request->portal_course_id;

        if ($course->isDirty('portal_course_id')) {
            $course->save();
        }

        // Get saved book's and request book's Ids and delete the books
        $savedBooksIds = $course->books()->pluck('id')->toArray();
        $requestBooksIds = Arr::pluck($request->input('books'), 'id');

        foreach ($savedBooksIds as $bookId) {
            if (!in_array($bookId, $requestBooksIds)) {
                Book::find($bookId)->delete();
            }
        }

        foreach ($request->input('books') as $bookData) {

            // Update or Save the books of the course
            if (Arr::exists($bookData, 'id')) {
                $book = Book::find($bookData['id']);
                $book->name = $bookData['name'];

                if ($book->isDirty('name')) {
                    $book->save();
                }
            } else {
                $book = $course->books()->create(['name' => $bookData['name']]);
                $book->save();
            }

            // Get saved lesson's and request lesson's Ids and delete the lessons
            $savedLessonsIds = $book->lessons()->pluck('id')->toArray();
            $requestLessonsIds = Arr::pluck($bookData['lessons'], 'id');

            foreach ($savedLessonsIds as $lessonId) {
                if (!in_array($lessonId, $requestLessonsIds)) {
                    Lesson::find($lessonId)->delete();
                }
            }

            // Update or Save the lessons of the book
            foreach ($bookData['lessons'] as $lessonData) {
                if (Arr::exists($lessonData, 'id')) {
                    $lesson = Lesson::find($lessonData['id']);
                    $lesson->name = $lessonData['name'];

                    if ($lesson->isDirty('name')) {
                        $lesson->save();
                    }
                } else {
                    $lesson = $book->lessons()->create(['name' => $lessonData['name']]);
                    $lesson->save();
                }
            }
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Course updated successfully.',
            'id' => $course->id,
        ]);
    }

    /**
     * Delete the course
     *
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            $course = Course::findOrFail($id);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'No Course found.',
            ]);
        }

        $course_lessons = $course->lessons()->get()->toArray();

        foreach ($course_lessons as $lesson) {

            $test = Test::where('lesson_id', '=', $lesson['id'])->first();

            if ($test) {
                $test->lesson_id = null;
                $test->save();
            }
        }

        $result = $course->delete();

        if ($result) {
            return response()->json([
                'status' => true,
                'message' => 'Course deleted successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Course was not deleted, Try again.',
            ]);
        }
    }
}
