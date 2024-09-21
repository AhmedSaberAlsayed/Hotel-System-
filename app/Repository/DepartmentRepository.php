<?php

namespace App\Repository;

use App\Models\Department;
use App\Http\Resources\DepartmentResource;
use App\RepositoryInterface\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function all($paginate)
    {
        $Department = Department::paginate($paginate);
        $data = [
            'Department' => DepartmentResource::collection($Department),
            'pagination' => [
                'total' => $Department->total(),
                'count' => $Department->count(),
                'per_page' => $Department->perPage(),
                'current_page' => $Department->currentPage(),
                'total_pages' => $Department->lastPage(),
                'first_page_url' => $Department->url(1),
                'last_page_url' => $Department->url($Department->lastPage()),
                'next_page_url' => $Department->nextPageUrl(),
                'prev_page_url' => $Department->previousPageUrl(),
                'path' => $Department->path(),
            ]
        ];
        return $data;
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
