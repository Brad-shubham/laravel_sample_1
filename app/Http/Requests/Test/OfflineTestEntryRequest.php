<?php

namespace App\Http\Requests\Test;

use App\Models\Test;
use App\Models\TestQuestion;
use Illuminate\Foundation\Http\FormRequest;

class OfflineTestEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'student_id' => 'required|exists:users,id',
            'test_id' => 'required|exists:tests,id',
            'grades' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'The student field is required.',
            'test_id.required' => 'The test field is required.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $grades = $this->input('grades');
            if ($grades) {
                $test = Test::find($this->input('test_id'));
                $totalMarks = $test->questions()->count() * TestQuestion::MAX_MARKS;

                if ($grades > $totalMarks) {
                    $validator->errors()->add('grades',
                        'Grades should be less than total marks.');
                } elseif ($grades < 0) {
                    $validator->errors()->add('grades',
                        'Grades should be not be less than zero.');
                }
            }
        });
    }
}
