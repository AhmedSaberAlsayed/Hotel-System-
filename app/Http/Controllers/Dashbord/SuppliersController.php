<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Requests\SuppliersRequest;
use App\Http\Resources\SuppliersResource;
use App\RepositoryInterface\SuppliersRepositoryInterface;

class SuppliersController extends Controller
{
    use Api_designtrait;

    protected $SuppliersRepository;

    public function __construct(SuppliersRepositoryInterface $SuppliersRepository)
    {
        $this->SuppliersRepository = $SuppliersRepository;
    }

    public function index()
    {
        $Supplierss = $this->SuppliersRepository->all(10);
        return $this->api_design(201, 'All Supplierss successfully', $Supplierss);
    }

    public function store(SuppliersRequest $request)
    {
        $Suppliers = $this->SuppliersRepository->create($request->validated());
        return $this->api_design(201, 'Suppliers added successfully', new SuppliersResource($Suppliers));
    }

    public function show($id)
    {
        $Suppliers = $this->SuppliersRepository->find($id);
        return $this->api_design(200, 'Selected Suppliers', new SuppliersResource($Suppliers));
    }

    public function update(SuppliersRequest $request, $id)
    {
        $Suppliers = $this->SuppliersRepository->update($id, $request->validated());
        if ($Suppliers) {
            return $this->api_design(200, 'Suppliers updated successfully', new SuppliersResource($Suppliers));
        }
        return $this->api_design(500, 'Suppliers update failed');
    }

    public function destroy($id)
    {
        $Suppliers = $this->SuppliersRepository->delete($id);
        return $this->api_design(200, 'Suppliers deleted successfully', new SuppliersResource($Suppliers));
    }
}
