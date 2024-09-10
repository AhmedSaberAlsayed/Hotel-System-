<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;
    protected $primaryKey = 'FeedbackID';

    protected $fillable = [
        'GuestID',
        'ServiceID',
        'Rating',
        'Comments',
        'FeedbackDate',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'GuestID');
    }

    public function book()
    {
        return $this->belongsTo(Booking::class, 'BookingID');
    }
}
