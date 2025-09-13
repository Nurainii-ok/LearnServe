<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TutorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ];

        // For update requests, make password optional and add unique constraints
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $tutorId = $this->route('id');
            $rules['name'] = ['required', 'string', 'max:100', Rule::unique('users')->ignore($tutorId)];
            $rules['email'] = ['required', 'email', Rule::unique('users')->ignore($tutorId)];
            $rules['password'] = 'nullable|string|min:4';
        } else {
            // For create requests, add unique constraints
            $rules['name'] .= '|unique:users,name';
            $rules['email'] .= '|unique:users,email';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Tutor name is required.',
            'name.unique' => 'This name is already taken.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 4 characters.',
        ];
    }
}