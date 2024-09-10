<?php

namespace App\Http\Controllers\Dashbord\Auth;

use App\Models\Staff;
use App\Http\Requests\StaffRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Resources\StaffResource;

class StaffController extends Controller
{
    use Api_designtrait;

    public function index()
    {
        $Staffs = Staff::with("department","supervisor")->paginate(5);
    return $this->api_design(201, 'All Staffs successfully',  StaffResource::collection($Staffs));
    }
    public function store(StaffRequest $request)
    {
            $staff = Staff::create($request->validated());
            return $this->api_design(201, 'staff registered successfully', new StaffResource($staff));
    }

    public function show(staff $staff)
    {
        return $this->api_design(200, 'Selected staff', new staffResource($staff));
    }


    public function update(StaffRequest $request,$id)
    {
        $updateSuccessful =staff::find($id);
        $updateSuccessful->update($request->validated());
        if ($updateSuccessful) {
            return $this->api_design(200, 'staff updated successfully', new staffResource($updateSuccessful));
        }
        return $this->api_design(500, 'staff update failed');
    }

    /**
     * Remove the specified staff resource from storage.
     */
    public function destroy($id)
    {
        $staff = Staff::find($id);
        $staff->delete();
        return $this->api_design(200, 'staff deleted successfully', new staffResource($staff));
    }
}
