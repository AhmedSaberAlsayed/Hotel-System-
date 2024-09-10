<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;
    protected $primaryKey = 'InventoryID';

    protected $fillable = [
        'ItemName',
        'QuantityInStock',
        'SupplierID',
        
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'SupplierID');
    }
}
