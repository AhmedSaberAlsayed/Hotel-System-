<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey = 'PaymentID';

    protected $fillable = [
        'BookingID' ,
        'PaymentDate',
        'Amount',
        'PaymentMethod',
        'PaymentStatus',
        'InvoiceNumber',
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'BookingID');
    }

    public function calculateAmount()
    {
        // Calculate the number of nights
      

        // Calculate room cost
        $roomCost = $this->booking->TotalPrice + $this->room->roomType->BasePrice ;
        // Total cost
        $totalPrice = $roomCost;
        return $totalPrice;
    }
}
