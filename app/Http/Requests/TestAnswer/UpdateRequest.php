<?php

namespace App\Http\Requests\TestAnswer;

use App\Models\TestQuestion;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        return [
            'submitted_answers' => 'required|array',
            'total_marks' => 'required',
            'percentage' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $marking = $this->input('submitted_answers');
            foreach ($marking['questions'] as $key => $question) {
                if ($question['type'] === TestQuestion::QUESTION_TYPE['Reflexive']) {
                    if ($question['score'] === null && $question['score'] !== 0) {
                        $validator->errors()->add('questions.'.$key.'.marks',
                            'Marks is required.');
                    } else {
                        if (!is_float($question['score']) && !is_integer($question['score'])) {
                            $validator->errors()->add('questions.'.$key.'.marks',
                                'The marks must be a number.');
                        } elseif ($question['score'] < 0) {
                            $validator->errors()->add('questions.'.$key.'.marks',
                                'The marks cannot be less then 0.');
                        } elseif ($question['score'] > TestQuestion::MAX_MARKS) {
                            $validator->errors()->add('questions.'.$key.'.marks',
                                'The marks must be less than max marks.');
                        }
                    }
                }
            }
        });
    }
}
