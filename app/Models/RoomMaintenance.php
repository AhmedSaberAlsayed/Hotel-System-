<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomMaintenance extends Model
{
    use HasFactory;

    protected $primaryKey = 'MaintenanceID';

    protected $fillable = [
        'RoomID',
        'StaffID',
        'MaintenanceDate',
        'Issue',
        'Description',
        'Status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomID');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'StaffID');
    }
}

