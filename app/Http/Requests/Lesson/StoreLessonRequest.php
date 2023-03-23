<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreLessonRequest extends FormRequest
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
            'book_id' => 'required|exists:books,id',
            'paragraphs' => 'array',
            'paragraphs.*.content' => 'required|min:3|max:10000',
            'paragraphs.*.image' => 'nullable',
            'paragraphs.*.image_position' => 'required_with:paragraphs.*.image',
            'paragraphs.*.image_name' => 'string|nullable|max:255',
            'paragraphs.*.questions' => 'array',
            'paragraphs.*.questions.*.question' => 'required|min:3|max:500',
        ];
    }

    /**
     * @return array|void
     */
    public function messages(){
        return [
            'name.required' => 'Lesson name is required.',
            'name.min' => 'Lesson name must be at least 3 characters.',
            'name.max' => 'Lesson name may not be greater than 255 characters.',
            'book_id.required' => 'Select the book.',
            'paragraphs.*.content.required' => 'Paragraph content is required.',
            'paragraphs.*.content.min' => 'Paragraph content must be at least 3 characters.',
            'paragraphs.*.content.max' => 'Paragraph content may not be greater than 10000 characters.',
            'paragraphs.*.image' => 'Paragraph image size should be less than 2Mb.',
            'paragraphs.*.image_name.string' => 'Paragraph image name should be string.',
            'paragraphs.*.image_name.max' => 'Paragraph image name may not be greater than 255 characters.',
            'paragraphs.*.image_position.required_with' => 'Image position is required.',
            'paragraphs.*.questions.*.question.required' => 'Paragraph question is required.',
            'paragraphs.*.questions.*.question.min' => 'Paragraph question must be at least 3 characters.',
            'paragraphs.*.questions.*.question.max' => 'Paragraph question may not be greater than 500 characters.',
        ];
    }

    /**
     * @return array
     */
    public function lessonBaseData(): array {
        return $this->only(['name', 'book_id']);
    }

    /**
     * @param $key
     * @param array $paragraph
     * @return array
     */
    public function paragraphBaseData($key, array $paragraph): array
    {
        $paragraph['order_number'] = $key + 1;
        return Arr::only($paragraph, ['content', 'image_position', 'order_number']);
    }
}
