<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class GuestRequest extends FormRequest
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
        'Name'=>"required",
        'LoginType'=>"required",
        'Email'=>"required",
        'Password'=>"required",
        'Phone'=>"required",
        'Address'=>"required",
        'LoyaltyPoints'=>"",
        'MembershipLevel'=>"",
        ];
    }
}
