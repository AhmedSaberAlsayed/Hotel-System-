<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomMaintenanceRequest extends FormRequest
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
            'room_id' => 'required',
            'Issue' => 'required|string',
            'maintenance_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed,In Progress',
            'MaintenanceDate' => 'required|date',
        ];
    }
}
