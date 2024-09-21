<?php

namespace App\Repository;

use App\Models\Staff;
use App\Http\Resources\StaffResource;
use App\RepositoryInterface\StaffRepositoryInterface;

class StaffRepository implements StaffRepositoryInterface
{
    public function all($paginate)
    {
        $staff = Staff::with('department', 'supervisor')->paginate($paginate);
        $data = [
            'staff' => StaffResource::collection($staff),
            'pagination' => [
                'total' => $staff->total(),
                'per_page' => $staff->perPage(),
                'current_page' => $staff->currentPage(),
                'total_pages' => $staff->lastPage(),
                'first_page_url' => $staff->url(1),
                'last_page_url' => $staff->url($staff->lastPage()),
                'next_page_url' => $staff->nextPageUrl(),
                'prev_page_url' => $staff->previousPageUrl(),
                'path' => $staff->path(),
            ]
        ];
        return $data;
    }

    public function find($id)
    {
        return Staff::with('department', 'supervisor')->find($id);
    }

    public function create(array $data)
    {
        return Staff::create($data);
    }

    public function update($id, array $data)
    {
        $staff = Staff::find($id);
        if ($staff) {
            $staff->update($data);
        }
        return $staff;
    }

    public function delete($id)
    {
        $staff = Staff::find($id);
        if ($staff) {
            $staff->delete();
        }
        return $staff;
    }
}
