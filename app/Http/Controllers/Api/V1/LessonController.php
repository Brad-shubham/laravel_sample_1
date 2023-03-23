<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * This function return the lesson list.
     * @param  $id
     * @return JsonResponse
     */
    public function lessonList($id)
    {
        try
        {
            $lesson_list = Lesson::where('book_id', $id)->get();
            $data['lesson'] = $lesson_list;
            return response()->json($data, 200);

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 403);

        }

    }

    /**
     * This function return the lesson details.
     * @param  $id
     * @return JsonResponse
     */
    public function lesson($id)
    {

        try
        {
            $student_id = Auth::user()->id;
            $lesson = Lesson::with(['paragraphs', 'paragraphs.questions.paraAnswer' => function($query) use ($student_id){
                $query->where('user_id', $student_id);
            }])->where('id', $id)->first();

            // Prepare parapraph image url and update
            foreach ($lesson->paragraphs as $paragraph) {
                if (!is_null($paragraph->image)) {
                    $paragraph->image = Storage::disk('paragraph-images')->url($paragraph->image);
                }
            }

            $data['lesson'] = $lesson;
            return response()->json($data, 200);

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 403);
        }

    }
}
