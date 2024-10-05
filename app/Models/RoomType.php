<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomType extends Model
{
    use HasFactory;

    protected $primaryKey = 'RoomTypeID';

    protected $fillable = [
        'RoomTypeName',
        'Description',
        'BasePrice',
    ];


    /**
     * Relationship to the Room model.
     * A RoomType can have many rooms associated with it.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class, 'RoomTypeID');
    }

}
