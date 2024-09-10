<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
        'GuestID' => 'required',
        'ServiceID' => 'required|string|max:255',
        'Rating' => 'required|string|max:255',
        'Comments' => 'required|string|max:255',
        'FeedbackDate' => 'required|string|max:1000',
        ];
    }
}
