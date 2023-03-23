<?php

namespace App\Http\Controllers;

use App\Http\Requests\Books\StoreBookRequest;
use App\Http\Requests\Books\UpdateBookRequest;
use App\Models\Book;
use App\Models\BookSection;
use App\Models\Course;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;


class BookController extends Controller
{
    /**
     * Returns view which contains the list of books
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('books.list');
    }

    /**
     * Returns the books data for listing
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBooksData(Request $request)
    {
        $sortByColumn = 'course_id';
        $sortOrder = 'asc';
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

        $books = Book::withCount('lessons')->with('course')
            ->where("books.name", "LIKE", "%$searchValue%")
            ->orderBy($sortByColumn, $sortOrder)
            ->paginate($length);

        if ($request->expectsJson()) {
            return response()->json($books, 200);
        }
    }


    /**
     * Returns view to create a new book
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $courses = Course::get(['id', 'name']);
        return view('books.create', compact('courses'));
    }

    /**
     * Save a new book
     *
     * @param StoreBookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBookRequest $request)
    {

        DB::beginTransaction();

        $book = new Book($request->bookBaseData());
        $extension = $request->extension;

        if($extension!=null){
            $coverImage = explode(",",$request->cover_image);
            $coverImage64 = base64_decode($coverImage[1]);
            $imgName = md5(uniqid(strtotime(now()), true)) . '.' . $extension;

            Storage::disk('books-cover')->put($imgName, $coverImage64, 'public');
            if(Storage::disk('books-cover')->exists($book->cover_image)){
                Storage::disk('books-cover')->delete($book->cover_image);
            }
            $book->cover_image = $imgName;
            $book->cover_image_name = $request->cover_image_name;
        }

        $book->fill($request->only(['name', 'author', 'publisher', 'course_id']));
        $book->save();

        foreach ($request->input('book_sections') as $bookSectionData) {
            $book_section = $book->bookSections()->create($request->bookSectionBaseData($bookSectionData));

            if(Arr::exists($bookSectionData, 'image_extension') ){
                $extension = $bookSectionData['image_extension'];

                if ($extension != null) {
                    $bookSectionImage = explode(",", $bookSectionData['image']);
                    $bookSectionImage64 = base64_decode($bookSectionImage[1]);
                    $imgName = md5(uniqid(strtotime(now()), true)) . '.' . $extension;

                    Storage::disk('book-section-images')->put($imgName, $bookSectionImage64);
                    $book_section->image = $imgName;
                    $book_section->image_name = $bookSectionData['image_name'];
                }
            }
            $book_section->save();
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Book created successfully.',
            'id' => $book->id,
        ]);
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $courses = Course::get(['id', 'name']);
        $book->loadMissing('bookSections');

        if(!is_null($book->cover_image)){
            $book->cover_image = Storage::disk('books-cover')->url($book->cover_image);
        }

        // Prepare book sections image url and update
        foreach ($book->bookSections as $bookSection) {
            if (!is_null($bookSection->image)) {
                $bookSection->image = Storage::disk('book-section-images')->url($bookSection->image);
            }
        }

        return response()->view('books.view', compact('book', 'courses'));
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $courses = Course::get(['id', 'name']);
        $book->loadMissing('bookSections');

        if(!is_null($book->cover_image)){
            $book->cover_image = Storage::disk('books-cover')->url($book->cover_image);
        }

        // Prepare book sections image url and update
        foreach ($book->bookSections as $bookSection) {
            if (!is_null($bookSection->image)) {
                $bookSection->image = Storage::disk('book-section-images')->url($bookSection->image);
            }
        }

        return response()->view('books.edit', compact('book', 'courses'));
    }

    /**
     * @param UpdateBookRequest $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        DB::beginTransaction();

        $extension = $request->extension;

        // update cover image
        if($extension!=null){
            $coverImage = explode(",",$request->cover_image);
            $coverImage64 = base64_decode($coverImage[1]);
            $imgName = md5(uniqid(strtotime(now()), true)) . '.' . $extension;

            Storage::disk('books-cover')->put($imgName, $coverImage64, 'public');
            if(Storage::disk('books-cover')->exists($book->cover_image)){
                Storage::disk('books-cover')->delete($book->cover_image);
            }
            $book->cover_image = $imgName;
            $book->cover_image_name = $request->cover_image_name;
        }

        if($request->cover_image == null && Storage::disk('books-cover')->exists($book->cover_image)){
            Storage::disk('books-cover')->delete($book->cover_image);
            $book->cover_image = null;
            $book->cover_image_name = null;
        }

        $book->fill($request->only(['name', 'author', 'publisher', 'course_id']));
        $book->save();

        // Get saved book sections's and request book section's Ids and delete the book sections
        $savedBookSectionIds = $book->bookSections()->pluck('id')->toArray();
        $requestBookSectionIds = Arr::pluck($request->input('book_sections'), 'id');

        foreach ($savedBookSectionIds as $bookSectionId) {
            if (!in_array($bookSectionId, $requestBookSectionIds)) {
                BookSection::find($bookSectionId)->delete();
            }
        }

        foreach ($request->input('book_sections') as $bookSectionData) {
            // Update or Create the book sections
            if (Arr::exists($bookSectionData, 'id')) {
                $bookSection = BookSection::findorFail($bookSectionData['id']);
                $bookSection->update(['title' => $bookSectionData['title'], 'content' => $bookSectionData['content']]);
            } else {
                $bookSection = BookSection::create(['book_id' => $book->id, 'title' => $bookSectionData['title'], 'content' => $bookSectionData['content']]);
            }

            if(Arr::exists($bookSectionData, 'image_extension') ){
                if ($bookSectionData['image_extension'] != null) {
                    $bookSectionImage = explode(",", $bookSectionData['image']);
                    $bookSectionImage64 = base64_decode($bookSectionImage[1]);
                    $imgName = md5(uniqid(strtotime(now()), true)) . '.' . $bookSectionData['image_extension'];

                    Storage::disk('book-section-images')->put($imgName, $bookSectionImage64);

                    if (Storage::disk('book-section-images')->exists($bookSection->image)) {
                        Storage::disk('book-section-images')->delete($bookSection->image);
                    }

                    $bookSection->image = $imgName;
                    $bookSection->image_name = $bookSectionData['image_name'];
                }

                // Delete existing paragraph image
                if($bookSectionData['image_extension'] == null && Storage::disk('book-section-images')->exists($bookSection->image)){
                    Storage::disk('book-section-images')->delete($bookSection->image);
                    $bookSection->image = null;
                    $bookSection->image_name = null;
                }

                $bookSection->save();
            }

        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Book updated successfully.',
            'id' => $book->id,
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'No Book found.',
            ]);
        }

        $book_lessons = $book->lessons()->get()->toArray();

        foreach ($book_lessons as $lesson) {

            $test = Test::where('lesson_id', '=', $lesson['id'])->first();

            if ($test) {
                $test->lesson_id = null;
                $test->save();
            }
        }

        $result = $book->delete();

        if ($result) {
            return response()->json([
                'status' => true,
                'message' => 'Book deleted successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Book was not deleted, Try again.',
            ]);
        }
    }
}
