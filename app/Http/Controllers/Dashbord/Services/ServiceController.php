<?php

namespace App\Http\Controllers\Dashbord\Services;

use App\Model;
use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    use Api_designtrait;
    public function store(ServiceRequest $request){

        $service = Service::create($request->validated());
        return $this->api_design(200,"Service add succesfuly",new ServiceResource($service));
    }

    public function show(Service $Service)
    {
        return $this->api_design(200, 'Selected Service', new ServiceResource($Service));
    }

    public function update(ServiceRequest $request,$id)
    {
        $updateSuccessful =Service::find($id);
        $updateSuccessful->update($request->validated());
        if ($updateSuccessful) {
            return $this->api_design(200, 'Service updated successfully', new ServiceResource($updateSuccessful));
        }
        return $this->api_design(500, 'Service update failed');
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        $service->delete();
        return $this->api_design(200,"Service deleted succsefully", new ServiceResource($service));
    }
}
