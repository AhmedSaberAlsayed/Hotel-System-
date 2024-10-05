<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'RoomTypeID'=>$this->RoomTypeID ,
            'RoomTypeName'=>$this->RoomTypeName ,
            'Description'=>$this->Description ,
            'BasePrice'=>$this->BasePrice ,
            'Rooms' => RoomResource::collection($this->whenLoaded('rooms')),

        ];
    }
}
