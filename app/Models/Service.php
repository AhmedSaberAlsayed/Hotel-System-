<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $primaryKey = 'ServiceID';

    protected $fillable = [
        'ServiceName',
        'ServiceDescription',
        'ServicePrice',
        'ServiceCategory',
    ];
    public function serviceUsages()
    {
        return $this->hasMany(ServiceUsage::class, 'ServiceID');
    }
}
