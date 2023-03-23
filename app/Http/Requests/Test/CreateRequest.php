<?php

namespace App\Http\Requests\Test;

use App\Models\TestQuestion;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|string|min:3|max:255',
            'lesson_id' => 'required|integer|exists:lessons,id',
            'questions' => 'required|array',
            'questions.*.type' => 'required|integer',
            'questions.*.text' => 'required|string|min:3|max:255',
            'questions.*.options' => 'exclude_unless:questions.*.type,'.TestQuestion::QUESTION_TYPE['MCQ'].'|required|array|between:2,4',
            'questions.*.options.*.text' => 'exclude_unless:questions.*.type,'.TestQuestion::QUESTION_TYPE['MCQ'].'|required|string|max:255',
            'questions.*.options.*.is_answer' => 'exclude_unless:questions.*.type,'.TestQuestion::QUESTION_TYPE['MCQ'].'|boolean',
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $questions = $this->input('questions');
            foreach ($questions as $key => $question) {
                if ($question['type'] === TestQuestion::QUESTION_TYPE['MCQ']) {
                    $flag = 0;
                    $options = $question['options'];
                    foreach ($options as $option) {
                        if ($option['is_answer'] == 1) {
                            $flag = 1;
                        }
                    }
                    if (!$flag) {
                        $validator->errors()->add('questions.'.$key.'.options.is_answer',
                            'Option answer is required');
                    }
                }
            }
        });
    }

    public function messages()
    {
        return [
            'lesson_id.required' => 'Lesson is required',
            'lesson_id.exists' => 'Lesson id must already exists',
            'questions.required' => 'Test should have at least one question.',
            'questions.*.options.required' => 'Question must have at least two options.',
            'questions.*.options.between' => 'Question must have min 2 and max 4 options.',
            'questions.*.options.*.text.required' => 'Option text is required.',
            'questions.*.options.*.text.min' => 'Option text must be at least 3 characters.',
            'questions.*.options.*.text.max' => 'Option text may not be greater than 255 characters.',
            'questions.*.text.required' => 'Question text is required.',
            'questions.*.text.min' => 'Question text must be at least 3 characters.',
            'questions.*.text.max' => 'Question text may not be greater than 255 characters.',
            'questions.*.type.required' => 'Question type is required.',
        ];
    }
}
