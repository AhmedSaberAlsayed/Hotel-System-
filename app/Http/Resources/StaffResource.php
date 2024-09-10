<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'StaffID'=>$this->StaffID,
            'FirstName'=>$this->FirstName,
        'LastName'=>$this->LastName ,
        'Position'=>$this->Position ,
        'Email'=>$this->Email ,
        'Phone'=>$this->Phone,
        'Address'=>$this->Address ,
        'Salary'=>$this-> Salary,
        'DepartmentID'=>$this-> DepartmentID,
        'SupervisorID'=>$this->SupervisorID ,
        // 'Department' => new DepartmentResource($this->whenLoaded('department')),
        ];
    }
}
