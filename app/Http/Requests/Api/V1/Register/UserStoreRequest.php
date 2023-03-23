<?php

namespace App\Http\Requests\Api\V1\Register;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UserStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->has('student_id')){
            return [
                'email' => 'required|string|email',
                'surname' => 'required',
                'first_name' => 'required',
//                'last_name' => 'required',
                'password' => 'required',
                'phone_number' => 'required|numeric',

            ];
        }else{
            return [
                'email' => 'required|string|email|unique:users',
                'surname' => 'required',
                'first_name' => 'required',
//                'last_name' => 'required',
                'password' => 'required',
                'phone_number' => 'required|numeric|unique:users,phone_number',

            ];
        }
    }

    /**
     * Get the custom messages of that rule which return by the rules method
     *
     * @return array
     */

    public function messages()
    {
        return [
            'email.required' => 'Oops! Please enter email.',
            'surname.required' => 'Oops! Please enter surname.',
            'first_name.required' => 'Oops! Please enter first name.',
//            'last_name.required' => 'Oops! Please enter last name.',
            'phone_number.required' => 'Oops! Please enter phone number.',
            'phone_number.unique' => "Oops! The phone number you entered is already registered with us.",
            'password.required' => "Oops! Please enter password.",
        ];
    }

    /**
     * Data required to login from request
     *
     * @return array
     */
    public function registerData(): array
    {
        return [
            'surname' => $this->get('surname'),
            'first_name' => $this->get('first_name'),
            'last_name' => $this->get('last_name'),
            'phone_number' => $this->get('phone_number'),
            'email' => $this->get('email'),
            'password' => bcrypt($this->get('password')),
            'country_id' => $this->get('country_id')
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}