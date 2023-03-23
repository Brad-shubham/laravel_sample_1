<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreCourseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'portal_course_id' => 'required|min:1|max:50',
            'name' => 'required|min:3|max:255',
            'books' => 'array',
            'books.*.name' => 'required|min:3|max:255',
            'books.*.lessons' => 'array',
            'books.*.lessons.*.name' => 'required|min:3|max:255'
        ];
    }

    public function messages()
    {
        return [
            'portal_course_id.required' => 'Course ID is required.',
            'portal_course_id.min' => 'Course ID must be at least 1 characters.',
            'portal_course_id.max' => 'Course ID may not be greater than 50 characters.',
            'name.required' => 'Course name is required.',
            'name.min' => 'Course name must be at least 3 characters.',
            'name.max' => 'Course name may not be greater than 255 characters.',
            'books.required' => 'Course should have at least one book.',
            'books.*.name' => 'Course must have at least one book.',
            'books.*.name.required' => 'Book name is required.',
            'books.*.name.min' => 'Book name must be at least 3 characters.',
            'books.*.name.max' => 'Book name may not be greater than 255 characters.',
            'books.*.lessons' => 'Book must have at least one lesson.',
            'books.*.lessons.*.name.required' => 'Lesson name is required.',
            'books.*.lessons.*.name.min' => 'Lesson name must be at least 3 characters.',
            'books.*.lessons.*.name.max' => 'Lesson name may not be greater than 255 characters.',

        ];
    }

    /**
     * Returns the base data for course
     *
     * @return array
     */
    public function courseBaseData(): array
    {
        return $this->only(['portal_course_id', 'name']);
    }

    /**
     * Returns array of books information
     *
     * @return array
     */
    public function books(): array
    {
        return $this->only('books')['books'];
    }

    /**
     * Returns base information to create/update a book
     *
     * @param array $book
     * @return array
     */
    public function bookBaseData(array $book): array
    {
        return Arr::only($book, 'name');
    }

    /**
     * Returns list of lessons inside a book
     *
     * @param array $book
     * @return array
     */
    public function lessons(array $book): array
    {
        return Arr::only($book, 'lessons');
    }

    /**
     * Returns base data to create a lesson
     *
     * @param array $lesson
     * @return array
     */
    public function baseLessonData(array $lesson): array
    {
        return Arr::only($lesson, 'name');
    }
}
