<?php

namespace App\Http\Controllers\Dashbord\Services;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\RepositoryInterface\ServiceRepositoryInterface;
 
class ServiceController extends Controller
{
    use Api_designtrait;

    protected $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function store(ServiceRequest $request)
    {
        $service = $this->serviceRepository->create($request->validated());
        return $this->api_design(200, "Service added successfully", new ServiceResource($service));
    }

    public function show($id)
    {
        $service = $this->serviceRepository->find($id);
        if ($service) {
            return $this->api_design(200, 'Selected Service', new ServiceResource($service));
        }
        return $this->api_design(404, 'Service not found');
    }

    public function update(ServiceRequest $request, $id)
    {
        $service = $this->serviceRepository->update($id, $request->validated());
        if ($service) {
            return $this->api_design(200, 'Service updated successfully', new ServiceResource($service));
        }
        return $this->api_design(500, 'Service update failed');
    }

    public function destroy($id)
    {
        $service = $this->serviceRepository->delete($id);
        return $this->api_design(200, "Service deleted successfully", new ServiceResource($service));
    }
}
