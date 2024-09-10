<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $primaryKey = 'StaffID';

    protected $fillable = [
        'FirstName',
        'LastName',
        'Position',
        'Email',
        'Phone',
        'Address',
        'Salary',
        'DepartmentID',
        'SupervisorID',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'DepartmentID');
    }

    public function supervisor()
    {
        return $this->belongsTo(Staff::class, 'SupervisorID');
    }

    public function subordinates()
    {
        return $this->hasMany(Staff::class, 'SupervisorID');
    }
}
