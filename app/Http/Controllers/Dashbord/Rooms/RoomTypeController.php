<?php

namespace App\Http\Controllers\Dashbord\Rooms;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Requests\RoomTypeRequest;
use App\Http\Resources\RoomTypeResource;
use App\RepositoryInterface\RoomTypeRepositoryInterface;

class RoomTypeController extends Controller
{
    use Api_designtrait;
    protected $roomTypeRepository;
    public function __construct(RoomTypeRepositoryInterface $roomTypeRepository ) {
        $this->roomTypeRepository = $roomTypeRepository;
    }

    public function index()
    {
        return $this->roomTypeRepository->all(20);

    }
    public function store(RoomTypeRequest $request)
{
        $RoomType = $this->roomTypeRepository->create($request->all());
        return $this->api_design(201, 'RoomType added successfully', new RoomTypeResource($RoomType));
}
public function show($id)
{
    $RoomType = $this->roomTypeRepository->find($id);
    return $this->api_design(200, 'Selected RoomType', new RoomTypeResource($RoomType));
}
public function update(RoomTypeRequest $request,$id)
{
    $updateSuccessful =$this->roomTypeRepository->update( $id, $request->all());
    if ($updateSuccessful) {
        return $this->api_design(200, 'RoomType updated successfully', new RoomTypeResource($updateSuccessful));
    }
    return $this->api_design(500, 'RoomType update failed');
}

/**
 * Remove the specified staff resource from storage.
 */
public function destroy($id)
{
    $RoomType =$this->roomTypeRepository->delete($id);
    return $this->api_design(200, 'RoomType deleted successfully', new RoomTypeResource($RoomType));
}
}
