<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Rules\PersonNameRule;
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
        return [
            'email' => 'required|string|email:strict|max:255|unique:'.with(new User())->getTable().',email',
            'surname' => ['required', 'string', 'min:3', 'max:255'],
            'first_name' => ['required', 'string', 'min:3', 'max:255', new PersonNameRule()],
            'middle_name' => ['nullable', 'string', 'min:3', 'max:255', new PersonNameRule()],
            'country_code' => 'required|required_with:phone_number|numeric|digits_between:3,3',
            'phone_number' => 'required|required_with:country_code|numeric|digits_between:7,10',
            'country_id' => 'nullable|integer|exists:countries,id',
            'city' => 'nullable|string|max:255',
            'private_mail_po_number' => 'nullable|string|max:255',
            'org_po_number' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'postal_code_id' => 'nullable|integer|exists:postal_code,id',
        ];
    }
}
