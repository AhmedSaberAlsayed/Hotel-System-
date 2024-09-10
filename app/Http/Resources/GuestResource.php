<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->GuestID,
        'FirstName'=>$this->FirstName,
        'Password'=>$this->Password,
        'LastName'=>$this->LastName ,
        'Email'=>$this->Email ,
        'Phone'=>$this->Phone ,
        'Address'=>$this->Address ,
        'DateOfBirth'=>$this->DateOfBirth ,
        'LoyaltyPoints'=>$this->LoyaltyPoints ,
        'MembershipLevel'=>$this->MembershipLevel,
        ];
    }
}
