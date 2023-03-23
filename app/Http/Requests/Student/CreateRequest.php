<?php

namespace App\Http\Requests\Student;

use App\Models\User;
use App\Rules\PersonNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

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
        $currentYear = date('Y');
        return [
            'email' => 'nullable|string|email:strict|max:255|unique:'.with(new User())->getTable().',email',
            'surname' => ['required', 'string', 'min:3', 'max:255', new PersonNameRule()],
            'first_name' => ['required', 'string', 'min:3', 'max:255', new PersonNameRule()],
            'middle_name' => ['nullable', 'string', 'min:3', 'max:255', new PersonNameRule()],
            'country_code' => 'required|required_with:phone_number|numeric|digits_between:3,3',
            'phone_number' => 'required|required_with:country_code|numeric|digits_between:7,10',
            'is_old' => 'nullable|boolean',
            'old_student_id' => 'nullable',
            'country_id' => 'nullable|integer|exists:countries,id',
            'city' => 'nullable|string|max:255',
            'private_mail_po_number' => 'nullable|string|max:255',
            'org_po_number' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'postal_code_id' => 'nullable|integer|exists:postal_code,id',
            'date_enrolled' => 'nullable|date',
            'birth_year' => 'nullable|numeric|digits:4|lte:'.$currentYear,
            'encouragement_card_sent' => 'nullable|date',
            'prisoner' => 'nullable|boolean',
            'gender' => 'nullable|string',
            'marital_status' => 'nullable|string',
            'religion' => 'nullable|string',
            'course_language_id' => 'nullable|integer|exists:languages,id',
            'activity_status' => 'nullable|string',
            'comment' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'country_id.required' => 'The country field is required.',
            'birth_year.lte' => 'The birth year must be less than or equal current year.',
            'old_student_id.required_with' => 'The old student id is required',
        ];
    }
}
