<?php

namespace App\Http\Requests\Api\V1\Register;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StudentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
//    public function authorize()
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'student_id'=> 'required|numeric',
            'email' => 'required|string|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'phone_number' => 'required|numeric',
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
            'student_id' => 'Oops! Please enter the student id',
            'email.required' => 'Oops! Please enter email.',
            'first_name.required' => 'Oops! Please enter first name.',
            'phone_number.required' => 'Oops! Please enter phone number.',
            'phone_number.unique' => "Oops! The phone number you entered is already registered with us.",
            'password.required' => "Oops! Please enter password.",
        ];
    }

    /**
     * Data required to register from request
     *
     * @return array
     */
    public function studentData(): array
    {
        return [
            'student_id' => $this->get('student_id'),
            'first_name' => $this->get('first_name'),
            'last_name' => $this->get('last_name'),
            'phone_number' => $this->get('phone_number'),
            'email' => $this->get('email'),
            'password' => bcrypt($this->get('password')),
            'user_type' => $this->get('user_type'),
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
