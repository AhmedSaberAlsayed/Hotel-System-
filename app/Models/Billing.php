<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasFactory;

    protected $primaryKey = 'BillingID';

    protected $fillable = [
        'ReservationID',
        'TotalAmount',
        'BillingDate',
    ];

    // public function reservation()
    // {
    //     return $this->belongsTo(Reservation::class, 'ReservationID');
    // }
}
