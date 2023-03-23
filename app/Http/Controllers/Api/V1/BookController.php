<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * This function return the Book list.
     * @param  $id
     * @return JsonResponse
     */
    public function bookList($id)
    {
        try
        {
            $student_id = Auth::user()->id;

            $book_list = Book::with(['bookSections','lessons.lessonStatus' => function($query) use ($student_id){
                $query->where('student_id', $student_id);
            }])->with(['lessons.test.testProgress' => function($query) use ($student_id){
                $query->where('student_id', $student_id);
            }])->with(['lessons.test.testResult' => function($query) use ($student_id){
                $query->where('student_id', $student_id);
            }])->with('lessons.paragraphs')->where('course_id', $id)->get();
            // Prepare book sections image url and update
            foreach ($book_list as $bookSection) {

                if (!is_null($bookSection->cover_image)) {
                    $bookSection->image = Storage::disk('books-cover')->url($bookSection->cover_image);
                }
            }

            $data['book'] = $book_list;
            return response()->json($data, 200);

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 403);

        }

    }
}
