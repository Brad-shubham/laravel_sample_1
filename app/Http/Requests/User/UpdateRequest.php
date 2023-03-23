<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends CreateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['email'] = $rules['email'].','.$this->route('user')->id;
        $rules['country_id'] = 'required|integer|exists:countries,id';

        return $rules;
    }

    public function messages()
    {
        return [
            'country_id.required' => 'The country field is required.',
        ];
    }
}
