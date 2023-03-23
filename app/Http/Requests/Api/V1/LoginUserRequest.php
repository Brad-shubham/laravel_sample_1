<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class LoginUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required_without_all:phone_number|email|exists:users',
            'phone_number' => 'exists:users',
        ];
    }

    /**
     * Get the custom messages of that rule which return by the rules method
     *
     * @return array
     */

    public function messages()
    {
        return [
            'email.required_without_all' => 'Oops! Please enter email or phone_number.',
            'phone_number.exists' => "Oops! The phone number you entered is not in our system.",
            'email.exists' =>"Oops! The email you entered is not in our system.",
            'email.email' => "Oops! The email you entered is not correct.",
        ];
    }


    /**
     * Data required to login from request
     *
     * @return array
     */
    public function loginData(): array
    {
        if ($this->get('phone_number')){
            return [
                'phone_number' => $this->get('phone_number'),
                'password' => $this->get('password'),
            ];
        }elseif ($this->get('email')){

            return [
                'email' => $this->get('email'),
                'password' => $this->get('password'),
            ];
        }

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
