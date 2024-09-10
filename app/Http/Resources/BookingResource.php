<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        "BookingID"=>$this->BookingID,
        'GuestID' =>$this->GuestID ,
        'RoomID' =>$this-> RoomID,
        'CheckInDate'=>$this-> CheckInDate,
        'CheckOutDate'=>$this->CheckOutDate ,
        'BookingDate'=>$this->BookingDate ,
        'TotalPrice'=>$this-> TotalPrice,
        'PaymentStatus'=>$this->PaymentStatus ,
        'BookingStatus'=>$this->BookingStatus ,
        'SpecialRequests'=>$this->SpecialRequests ,
        'services'=>$this->services ,

        ];
    }
}
