<?php

namespace App\Repository;

use App\Models\Department;
use App\ReposatoryInterface\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function all($paginate)
    {
        return Department::with('staff')->paginate($paginate);
    }

    public function find($id)
    {
        return Department::with('staff')->find($id);
    }

    public function create(array $data)
    {
        return Department::create($data);
    }

    public function update($id, array $data)
    {
        $department = Department::find($id);
        if ($department) {
            $department->update($data);
        }
        return $department;
    }

    public function delete($id)
    {
        $department = Department::find($id);
        if ($department) {
            $department->delete();
        }
        return $department;
    }
}
