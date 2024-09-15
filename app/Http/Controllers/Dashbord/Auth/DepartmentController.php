<?php

namespace App\Http\Controllers\Dashbord\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\ReposatoryInterface\DepartmentRepositoryInterface;

class DepartmentController extends Controller
{
    use Api_designtrait;

    protected $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $departments = $this->departmentRepository->all(20);
        return $this->api_design(201, 'All Departments successfully', DepartmentResource::collection($departments));
    }

    public function store(DepartmentRequest $request)
    {
        $department = $this->departmentRepository->create($request->validated());
        return $this->api_design(201, 'Department added successfully', new DepartmentResource($department));
    }

    public function show($id)
    {
        $department = $this->departmentRepository->find($id);
        if ($department) {
            return $this->api_design(200, 'Selected Department', new DepartmentResource($department));
        }
        return $this->api_design(500, 'There is no Department with this id');
    }

    public function update(DepartmentRequest $request, $id)
    {
        $department = $this->departmentRepository->update($id, $request->validated());
        if ($department) {
            return $this->api_design(200, 'Department updated successfully', new DepartmentResource($department));
        }
        return $this->api_design(500, 'Department update failed');
    }

    public function destroy($id)
    {
        $department = $this->departmentRepository->delete($id);
        return $this->api_design(200, 'Department deleted successfully', new DepartmentResource($department));
    }
}
