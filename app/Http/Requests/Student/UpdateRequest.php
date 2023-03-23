<?php

namespace App\Http\Requests\Student;

use Illuminate\Support\Facades\Request;

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
        $rules['email'] = $rules['email'].','.$this->route('student')->id;
        $rules['country_id'] = 'required|integer|exists:countries,id';

        return $rules;
    }
}
