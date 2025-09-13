<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'task_id' => 'nullable|exists:tasks,id',
            'score' => 'required|numeric|min:0|max:100',
            'grade' => 'nullable|string|max:2|in:A,B,C,D,F,A+,B+,C+,D+',
            'type' => 'required|in:assignment,quiz,exam,project,participation',
            'feedback' => 'nullable|string|max:2000',
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'Please select a student.',
            'student_id.exists' => 'Selected student does not exist.',
            'class_id.required' => 'Please select a class.',
            'class_id.exists' => 'Selected class does not exist.',
            'task_id.exists' => 'Selected task does not exist.',
            'score.required' => 'Score is required.',
            'score.numeric' => 'Score must be a number.',
            'score.min' => 'Score cannot be negative.',
            'score.max' => 'Score cannot exceed 100.',
            'grade.max' => 'Grade cannot exceed 2 characters.',
            'grade.in' => 'Please enter a valid grade (A, B, C, D, F).',
            'type.required' => 'Grade type is required.',
            'type.in' => 'Please select a valid grade type.',
            'feedback.max' => 'Feedback cannot exceed 2000 characters.',
        ];
    }
}