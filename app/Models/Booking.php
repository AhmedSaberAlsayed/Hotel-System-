<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    protected $primaryKey = 'BookingID';
    protected $fillable = [
        'GuestID' ,
        'RoomID' ,
        'CheckInDate',
        'CheckOutDate',
        'BookingDate',
        'TotalPrice',
        'PaymentStatus',
        'BookingStatus',
        'SpecialRequests',
    ];


    public function guest()
    {
        return $this->belongsTo(Guest::class, 'GuestID');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomID');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'BookingID');
    }

    public function services()
    {
        return $this->hasMany(ServiceUsage::class, 'BookingID');
    }

    public function billings()
    {
        return $this->hasMany(Billing::class, 'BookingID');
    }

    public function calculateRoomCost()
    {
        // Calculate the number of nights
        $checkInDate = new \DateTime($this->CheckInDate);
        $checkOutDate = new \DateTime($this->CheckOutDate);
        $interval = $checkInDate->diff($checkOutDate);
        $nights = $interval->days;

        // Calculate room cost
        $roomCost = $nights * $this->room->PricePerNight * $this->room->roomType->BasePrice ;
        $totalPrice = $roomCost;
        return $totalPrice;
    }
}

