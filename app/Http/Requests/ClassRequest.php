<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'tutor_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0|max:999999.99',
            'category' => 'nullable|string|max:100',
        ];

        // For update requests, add status
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['status'] = 'required|in:active,inactive,completed';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Class title is required.',
            'title.max' => 'Class title cannot exceed 255 characters.',
            'description.required' => 'Class description is required.',
            'description.min' => 'Class description must be at least 10 characters.',
            'tutor_id.required' => 'Please select a tutor.',
            'tutor_id.exists' => 'Selected tutor does not exist.',
            'price.required' => 'Class price is required.',
            'price.min' => 'Class price cannot be negative.',
            'price.max' => 'Class price is too high.',
            'category.max' => 'Category cannot exceed 100 characters.',
        ];
    }
}