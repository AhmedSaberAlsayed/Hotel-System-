<?php

namespace App\Repository;

use App\Models\Staff;
use App\RepositoryInterface\StaffRepositoryInterface;

class StaffRepository implements StaffRepositoryInterface
{
    public function all($paginate)
    {
        return Staff::with('department', 'supervisor')->paginate($paginate);
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
