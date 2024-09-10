<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
    'RoomNumber',
    'RoomTypeID' ,
    'Capacity',
    'PricePerNight',
    'Status',
    'Floor',
    'ViewType',
    'Features',
    'image'
    ];

    protected $primaryKey = 'RoomID';

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'RoomID');
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'RoomTypeID');
    }

    public function maintenances()
    {
        return $this->hasMany(RoomMaintenance::class, 'RoomID');
    }
    public function getImageAttribute($value){
        return 'images/Rooms/' . $value;
    }
}
