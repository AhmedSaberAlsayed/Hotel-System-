<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You can add authorization logic here if needed
    }

    public function rules()
    {
        return [
            'ItemName' => 'required|string|max:255',
            'QuantityInStock' => 'required|integer|min:0',
            'SupplierID' => 'required|exists:suppliers,SupplierID',
        ];
    }
}
