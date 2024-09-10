<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceUsage extends Model
{
    use HasFactory;
    protected $primaryKey = "ServiceUsageID";
    protected $fillable = [
        'BookingID' ,
        'ServiceID' ,
        'StaffID' ,
        'UsageDate',
        'Quantity',
        'TotalCost',
    ];
    public function services()
    {
        return $this->belongsTo(Service::class, 'ServiceID');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'BookingID');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'StaffID');
    }

    public function calculateTotalCost()
    {
           // Calculate services cost
            $servicesCost = $this->Quantity * $this->services->ServicePrice ;
        // Total cost
        $totalPrice = $servicesCost;
        return $totalPrice;        
    }
}
