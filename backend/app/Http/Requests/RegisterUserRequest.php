<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string|max:128',
            'email' => 'required|email|unique:users,email|max:128',
            'username' => 'required|string|max:32|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'uni_reg_no' => 'required|string|max:10|unique:users,uni_reg_no',
            'university_id' => 'required|exists:universities,id',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'username.required' => 'Username is required.',
            'username.unique' => 'This username is already taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'uni_reg_no.required' => 'University registration number is required.',
            'uni_reg_no.unique' => 'This registration number is already in use.',
            'phoneNumber.unique' => 'The phone number is already registered as either email or username.',
        ];
    }
}
