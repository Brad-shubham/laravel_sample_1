<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'author' => 'required|min:3|max:255',
            'course_id' => 'required|exists:courses,id',
            'publisher' => 'nullable|min:3|max:5000',
            'cover_image' => 'nullable',
            'book_sections' => 'array',
            'book_sections.*.title' => 'required|min:3|max:255',
            'book_sections.*.content' => 'required|min:3|max:5000',
            'book_sections.*.book_section_image' => 'nullable',
            'book_sections.*.book_section_image_name' => 'string|nullable|max:255',
        ];
    }

    /**
     * @return array|void
     */
    public function messages(){
        return [
            'name.required' => 'Book name is required.',
            'name.min' => 'Book name must be at least 3 characters.',
            'name.max' => 'Book name may not be greater than 255 characters.',
            'author.required' => 'Author name is required.',
            'author.min' => 'Author name must be at least 3 characters.',
            'author.max' => 'Author name may not be greater than 255 characters.',
            'publisher.min' => 'Publisher content must be at least 3 characters.',
            'publisher.max' => 'Publisher content may not be greater than 5000 characters.',
            'course_id.required' => 'Select the course.',
            'cover_image' => 'Cover image size should be less than 2Mb.',
            'book_sections.*.title.required' => 'Title is required.',
            'book_sections.*.title.min' => 'Title must be at least 3 characters.',
            'book_sections.*.title.max' => 'Title may not be greater than 255 characters.',
            'book_sections.*.content.required' => 'Content is required.',
            'book_sections.*.content.min' => 'Content must be at least 3 characters.',
            'book_sections.*.content.max' => 'Content may not be greater than 5000 characters.',
            'book_sections.*.book_section_image' => 'Image size should be less than 2Mb.',
            'book_sections.*.book_section_image_name.string' => 'Image name should be string.',
            'book_sections.*.book_section_image_name.max' => 'Image name may not be greater than 255 characters.',

        ];
    }

    /**
     * @return array
     */
    public function bookBaseData(): array {
        return $this->only(['name','author','course_id','publisher','cover']);
    }

    public function bookSectionBaseData(array $bookSection): array {
        return Arr::only($bookSection, ['title','content']);

    }
}
