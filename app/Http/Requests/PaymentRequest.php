<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
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
    public function rules(): array
    {
        return [
        'PaymentStatus'=>'',
        'InvoiceNumber'=>'',
        'BookingID' => 'required|exists:bookings,BookingID',
        'Amount' => '',
        'PaymentDate' => '',
        'PaymentMethod' => [
                '',
                Rule::in(['Credit Card', 'Cash', 'Bank Transfer', 'Mobile Payment']), // Acceptable payment methods
        ],
        [
            'Amount.min' => 'The amount must be greater than zero.',
            'PaymentMethod.in' => 'The selected payment method is invalid.',
        ]
        ];
    }
}
