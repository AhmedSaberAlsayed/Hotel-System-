<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends Model
{
    use HasApiTokens;

    use HasFactory;
    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
        'Password',
        'Phone',
        'Address',
        'DateOfBirth',
        'LoyaltyPoints',
        'MembershipLevel',
    ];

    protected $primaryKey = 'GuestID';

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'GuestID');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'GuestID');
    }
}
