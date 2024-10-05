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
        'Name'=>$this->Name,
        'Email'=>$this->Email ,
        'Password'=>$this->Password,
        'LoginType'=>$this->LoginType,
        'Phone'=>$this->Phone,
        'Address'=>$this->Address ,
        'LoyaltyPoints'=>$this->LoyaltyPoints ,
        'MembershipLevel'=>$this->MembershipLevel,
        ];
    }
}
