<?php

namespace App\Http\Controllers\Dashbord\Auth;

use App\Http\Requests\StaffRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Resources\StaffResource;
use App\RepositoryInterface\StaffRepositoryInterface;

class StaffController extends Controller
{
    use Api_designtrait;

    protected $staffRepository;

    public function __construct(StaffRepositoryInterface $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    public function index()
    {
        $Staffs = $this->staffRepository->all(5);
        return $this->api_design(201, 'All Staffs successfully', StaffResource::collection($Staffs));
    }

    public function store(StaffRequest $request)
    {
        $staff = $this->staffRepository->create($request->validated());
        return $this->api_design(201, 'Staff registered successfully', new StaffResource($staff));
    }

    public function show($id)
    {
        $staff = $this->staffRepository->find($id);
        return $this->api_design(200, 'Selected staff', new StaffResource($staff));
    }

    public function update(StaffRequest $request, $id)
    {
        $staff = $this->staffRepository->update($id, $request->validated());
        if ($staff) {
            return $this->api_design(200, 'Staff updated successfully', new StaffResource($staff));
        }
        return $this->api_design(500, 'Staff update failed');
    }

    public function destroy($id)
    {
        $staff = $this->staffRepository->delete($id);
        return $this->api_design(200, 'Staff deleted successfully', new StaffResource($staff));
    }
}
