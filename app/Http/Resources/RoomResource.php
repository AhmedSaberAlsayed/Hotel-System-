<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'RoomID' =>$this->RoomID ,
            'RoomNumber' =>$this->RoomNumber ,
            'RoomTypeID'  =>$this-> RoomTypeID,
            'Capacity' =>$this->Capacity ,
            'PricePerNight' =>$this->PricePerNight ,
            'Status' =>$this->Status ,
            'Floor' =>$this->Floor ,
            'ViewType' =>$this->ViewType ,
            'Features' =>$this->Features ,
            'image' =>asset($this->image),
        ];
    }
}
