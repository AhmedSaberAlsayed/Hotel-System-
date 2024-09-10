<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $primaryKey = 'DepartmentID';

    protected $fillable = [
        'DepartmentName',
        'Description',
        'ManagerID',
    ];

    public function manager()
    {
        return $this->belongsTo(Staff::class, 'ManagerID');
    }

    public function staff()
    {
        return $this->hasMany(Staff::class, 'DepartmentID');
    }
}
