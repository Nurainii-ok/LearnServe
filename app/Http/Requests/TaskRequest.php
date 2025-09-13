<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'class_id' => 'required|exists:classes,id',
            'assigned_by' => 'required|exists:users,id',
            'due_date' => 'required|date|after:now',
            'priority' => 'required|in:low,medium,high',
            'instructions' => 'nullable|string|max:2000',
        ];

        // For update requests, allow past due dates and add status
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['due_date'] = 'required|date';
            $rules['status'] = 'required|in:pending,in_progress,completed,overdue';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Task title is required.',
            'title.max' => 'Task title cannot exceed 255 characters.',
            'description.required' => 'Task description is required.',
            'description.min' => 'Task description must be at least 10 characters.',
            'class_id.required' => 'Please select a class.',
            'class_id.exists' => 'Selected class does not exist.',
            'assigned_by.required' => 'Please select who assigned this task.',
            'assigned_by.exists' => 'Selected user does not exist.',
            'due_date.required' => 'Due date is required.',
            'due_date.after' => 'Due date must be in the future.',
            'priority.required' => 'Task priority is required.',
            'priority.in' => 'Please select a valid priority level.',
            'instructions.max' => 'Instructions cannot exceed 2000 characters.',
            'status.required' => 'Task status is required.',
            'status.in' => 'Please select a valid task status.',
        ];
    }
}