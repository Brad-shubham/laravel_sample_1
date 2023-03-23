<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileRequest extends FormRequest
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
            'email' => 'required|string|email:strict|max:255|unique:'.with(new User())->getTable().',email,'.$this->route('user')->id,
            'surname' => ['required', 'string', 'min:3', 'max:255'],
            'first_name' => ['required', 'string', 'min:3', 'max:255'],
            'middle_name' => ['nullable', 'string', 'min:3', 'max:255'],
            'old_password' => 'required_with:password',
            'password' => 'required_with:old_password|nullable|string|same:password_confirmation',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $oldPassword = $this->input('old_password');
            if (!empty($oldPassword) && !Hash::check($oldPassword, Auth::user()->getAuthPassword())) {
                $validator->errors()->add('old_password',
                    'The current password field does not match with your stored password.');
            }
        });
    }
}
