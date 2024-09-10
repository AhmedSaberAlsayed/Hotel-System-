<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    protected $primaryKey = 'SupplierID';

    protected $fillable = [
        'SupplierName',
        'ContactNumber',
        'Address',
        'Phone',
        'Email',
    ];

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'SupplierID');
    }
}
