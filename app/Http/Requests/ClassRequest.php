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
            'capacity' => 'required|integer|min:1|max:100',
            'price' => 'required|numeric|min:0|max:999999.99',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'schedule' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
        ];

        // For update requests, allow past dates and add status
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['start_date'] = 'required|date';
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
            'capacity.required' => 'Class capacity is required.',
            'capacity.min' => 'Class capacity must be at least 1.',
            'capacity.max' => 'Class capacity cannot exceed 100.',
            'price.required' => 'Class price is required.',
            'price.min' => 'Class price cannot be negative.',
            'price.max' => 'Class price is too high.',
            'start_date.required' => 'Start date is required.',
            'start_date.after_or_equal' => 'Start date cannot be in the past.',
            'end_date.required' => 'End date is required.',
            'end_date.after' => 'End date must be after start date.',
            'schedule.max' => 'Schedule cannot exceed 500 characters.',
            'category.max' => 'Category cannot exceed 100 characters.',
        ];
    }
}