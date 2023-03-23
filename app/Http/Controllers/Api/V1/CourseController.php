<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\LessonStatus;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * This function return the course data.
     *
     * @return JsonResponse
     */
    public function course(){
        try{
            $student_id =Auth::user()->id;

            $courseList = Course::with(['books.lessons.lessonStatus' => function($query) use ($student_id){
                $query->where('student_id', $student_id);
            }])->with(['books.lessons.test.testProgress' => function($query) use ($student_id){
                $query->where('student_id', $student_id);
            }])->with(['books.lessons.test.testResult' => function($query) use ($student_id){
                $query->where('student_id', $student_id);
            }])->with('books.lessons.paragraphs')->get();

            

            $i = 0;
            foreach ($courseList as $course){

                foreach ($course->books as $bookSection) {
                    if (!is_null($bookSection->cover_image)) {
                        $bookSection->image = Storage::disk('books-cover')->url($bookSection->cover_image);
                    }
                }
                $course_status = DB::table('course_progress')->where('course_id', $course['id'])->where('student_id', Auth::user()->id)->first();
                $courseList[$i]['course_status']  = $course_status;
                $i++;
            }

            $data['course'] = $courseList;
            return response()->json($data);

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 403);
        }

    }

    public function show($courseId)
    {
        try {
            $student_id =Auth::user()->id;
            $course = Course::where('id', $courseId)->get();
            foreach ($course->books as $bookSection) {
                if (!is_null($bookSection->cover_image)) {
                    $bookSection->image = Storage::disk('books-cover')->url($bookSection->cover_image);
                }
            }
            $course_status = DB::table('course_progress')->where('course_id', $course['id'])->where('student_id', $student_id)->first();
            $course->course_status = $course_status;
            return response()->json($course);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
