<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'amount' => 'required|numeric|min:0|max:999999.99',
            'payment_method' => 'required|string|in:credit_card,debit_card,bank_transfer,paypal,cash',
            'notes' => 'nullable|string|max:1000',
        ];

        // For create requests, require unique transaction_id
        if ($this->isMethod('POST')) {
            $rules['transaction_id'] = 'required|string|max:100|unique:payments,transaction_id';
        }

        // For update requests, add status field
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['status'] = 'required|in:pending,completed,failed,refunded';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Please select a user.',
            'user_id.exists' => 'Selected user does not exist.',
            'class_id.required' => 'Please select a class.',
            'class_id.exists' => 'Selected class does not exist.',
            'amount.required' => 'Payment amount is required.',
            'amount.numeric' => 'Payment amount must be a number.',
            'amount.min' => 'Payment amount cannot be negative.',
            'amount.max' => 'Payment amount is too high.',
            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Please select a valid payment method.',
            'transaction_id.required' => 'Transaction ID is required.',
            'transaction_id.unique' => 'This transaction ID already exists.',
            'transaction_id.max' => 'Transaction ID cannot exceed 100 characters.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
            'status.required' => 'Payment status is required.',
            'status.in' => 'Please select a valid payment status.',
        ];
    }
}