<?php

namespace App\Http\Controllers\Dashbord\Auth;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;

class DepartmentController extends Controller
{
    use Api_designtrait;

    public function index()
    {
        $departments = Department::with("staff")->paginate(20);
    return $this->api_design(201, 'All Departments successfully',  DepartmentResource::collection($departments));
    }
        public function store(DepartmentRequest $request)
    {
            $department = Department::create($request->validated());
            return $this->api_design(201, 'Department added successfully', new DepartmentResource($department));
    }
    public function show($id)
    {
        $department = Department::find($id);
        if ($department) {

            return $this->api_design(200, 'Selected Department', new DepartmentResource($department));
        }
        return $this->api_design(500, 'There is no Department with this id  ',null,);

    }


    public function update(DepartmentRequest $request,$id)
    {
        $updateSuccessful =Department::find($id);
        $updateSuccessful->update($request->validated());
        if ($updateSuccessful) {
            return $this->api_design(200, 'Department updated successfully', new DepartmentResource($updateSuccessful));
        }
        return $this->api_design(500, 'Department update failed');
    }

    /**
     * Remove the specified staff resource from storage.
     */
    public function destroy($id)
    {
        $department =Department::find($id);
        $department->delete();
        return $this->api_design(200, 'Department deleted successfully', new DepartmentResource($department));
    }
}
