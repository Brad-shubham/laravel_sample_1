<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lesson\StoreLessonRequest;
use App\Http\Requests\Lesson\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Paragraph;
use App\Models\Lesson;
use App\Models\ParagraphQuestion;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lessons.list');
    }

    /**
     * Returns the lessons data for the listing
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getlessonsData(Request $request)
    {
        $sortByColumn = 'lessons.id';
        $sortOrder = 'ASC';
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

            if ($sortByColumn === 'name') {
                $sortByColumn = 'lessons.'.$sortByColumn;
            }
        }

        if ($request->filled(['search'])) {
            $searchValue = $request->input('search');
        }

        $lessons = Lesson::select('lessons.*', 'books.name as book_name')
            ->withCount('paragraphs')
            ->join('books', 'books.id', '=', 'lessons.book_id')
            ->join('courses', 'courses.id', '=', 'books.course_id')
            ->when($searchValue, function ($q) use ($searchValue) {
                $q->where("lessons.name", "LIKE", "%$searchValue%");
            })
            ->when($sortByColumn === 'lessons.id', function ($q) use ($sortByColumn) {
                $q->orderBy('courses.id', 'ASC')
                    ->orderBy('books.id', 'ASC');
            })
            ->orderBy($sortByColumn, $sortOrder)
            ->paginate($length);

        if ($request->expectsJson()) {
            return response()->json($lessons, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books = Book::get(['id', 'name']);
        return view('lessons.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request)
    {
        DB::beginTransaction();

        $lesson = new Lesson($request->lessonBaseData());
        $lesson->save();

        foreach ($request->input('paragraphs') as $key => $paragraphData) {
            $paragraph = $lesson->paragraphs()->create($request->paragraphBaseData($key, $paragraphData));

            if (Arr::exists($paragraphData, 'image_extension')) {
                $extension = $paragraphData['image_extension'];

                if ($extension != null) {
                    $paragraphImage = explode(",", $paragraphData['image']);
                    $paragraphImage64 = base64_decode($paragraphImage[1]);
                    $imgName = md5(uniqid(strtotime(now()), true)).'.'.$extension;

                    Storage::disk('paragraph-images')->put($imgName, $paragraphImage64);
                    $paragraph->image = $imgName;
                    $paragraph->image_name = $paragraphData['image_name'];
                }
            }
            $paragraph->save();

            foreach ($paragraphData['questions'] as $questionData) {
                $paragraph->questions()->create($questionData);
            }
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Lesson created successfully.',
            'id' => $lesson->id,
        ]);
    }

    /**
     * @param  Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        $books = Book::get(['id', 'name']);
        $lesson->loadMissing('paragraphs.questions');

        // Prepare parapraph image url and update
        foreach ($lesson->paragraphs as $paragraph) {
            if (!is_null($paragraph->image)) {
                $paragraph->image = Storage::disk('paragraph-images')->url($paragraph->image);
            }
        }

        return response()->view('lessons.view', compact('lesson', 'books'));
    }

    /**
     * Show the form for editing the specified Lesson.
     *
     * @param  Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        $books = Book::get(['id', 'name']);
        $lesson->loadMissing('paragraphs.questions');

        // Prepare parapraph image url and update
        foreach ($lesson->paragraphs as $paragraph) {
            if (!is_null($paragraph->image)) {
                $paragraph->image = Storage::disk('paragraph-images')->url($paragraph->image);
            }
        }

        return response()->view('lessons.edit', compact('lesson', 'books'));
    }

    /**
     * Update the Lesson
     *
     * @param  UpdateLessonRequest  $request
     * @param  Lesson  $lesson
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        DB::beginTransaction();

        $lesson->fill($request->only(['name', 'book_id']));
        $lesson->save();

        // Get saved paragraph's Id and request paragraph's Ids
        $savedParagraphsIds = $lesson->paragraphs()->pluck('id')->toArray();
        $requestParagraphsIds = Arr::pluck($request->input('paragraphs'), 'id');

        // Delete the paragraph if saved paragraph ID not found in the request paragraphs
        foreach ($savedParagraphsIds as $paragraphId) {
            if (!in_array($paragraphId, $requestParagraphsIds)) {
                Paragraph::find($paragraphId)->delete();
            }
        }

        // Update paragraphs
        foreach ($request->input('paragraphs') as $key => $paragraphData) {

            // Update or Create the Paragraphs
            if (Arr::exists($paragraphData, 'id')) {
                $paragraph = Paragraph::findorFail($paragraphData['id']);
                $paragraph->update([
                    'content' => $paragraphData['content'],
                    'image_position' => $paragraphData['image_position'],
                    'order_number' => ($key + 1)
                ]);
            } else {
                $paragraph = Paragraph::create([
                    'lesson_id' => $request->id,
                    'content' => $paragraphData['content'],
                    'image_position' => $paragraphData['image_position'],
                    'order_number' => ($key + 1)
                ]);
            }

            if (Arr::exists($paragraphData, 'image_extension')) {
                if ($paragraphData['image_extension'] != null) {
                    $paragraphImage = explode(",", $paragraphData['image']);
                    $paragraphImage64 = base64_decode($paragraphImage[1]);
                    $imgName = md5(uniqid(strtotime(now()), true)).'.'.$paragraphData['image_extension'];

                    Storage::disk('paragraph-images')->put($imgName, $paragraphImage64);

                    if (Storage::disk('paragraph-images')->exists($paragraph->image)) {
                        Storage::disk('paragraph-images')->delete($paragraph->image);
                    }

                    $paragraph->image = $imgName;
                    $paragraph->image_name = $paragraphData['image_name'];
                }

                // Delete existing paragraph image
                if ($paragraphData['image_extension'] == null && Storage::disk('paragraph-images')->exists($paragraph->image)) {
                    Storage::disk('paragraph-images')->delete($paragraph->image);
                    $paragraph->image = null;
                    $paragraph->image_name = null;
                }

                $paragraph->save();
            }


            // Get saved question's Id and request question's Ids
            $savedQuestionsIds = $paragraph->questions->pluck('id')->toArray();
            $requestQuestionsIds = Arr::pluck($paragraphData['questions'], 'id');

            // Delete the question if saved question ID not found in the request question
            foreach ($savedQuestionsIds as $questionId) {
                if (!in_array($questionId, $requestQuestionsIds)) {
                    ParagraphQuestion::find($questionId)->delete();
                }
            }

            // Update paragraph's questions
            foreach ($paragraphData['questions'] as $questionData) {

                // Update or Create the Paragraph Questions
                if (Arr::exists($questionData, 'id')) {
                    $question = ParagraphQuestion::findorFail($questionData['id']);
                    $question->update(['question' => $questionData['question']]);
                } else {
                    ParagraphQuestion::create([
                        'paragraph_id' => $paragraph->id, 'question' => $questionData['question']
                    ]);
                }
            }
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Lesson updated successfully.',
            'id' => $lesson->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $lesson = Lesson::findOrFail($id);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'No Lesson found.',
            ]);
        }

        $test = Test::where('lesson_id', '=', $lesson->id)->first();

        if ($test) {
            $test->lesson_id = null;
            $test->save();
        }

        $result = $lesson->delete();

        if ($result) {
            return response()->json([
                'status' => true,
                'message' => 'Lesson deleted successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Lesson was not deleted, Try again.',
            ]);
        }
    }
}
