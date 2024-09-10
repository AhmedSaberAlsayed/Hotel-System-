<?php

namespace App\Http\Controllers\Dashbord\Rooms;

use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Requests\RoomTypeRequest;
use App\Http\Resources\RoomTypeResource;


class RoomTypeController extends Controller
{
    use Api_designtrait;
    public function store(RoomTypeRequest $request)
{
        $RoomType = RoomType::create($request->validated());
        return $this->api_design(201, 'RoomType added successfully', new RoomTypeResource($RoomType));
}
public function show(RoomType $RoomType)
{
    return $this->api_design(200, 'Selected RoomType', new RoomTypeResource($RoomType));
}
public function update(RoomTypeRequest $request,$id)
{
    $updateSuccessful =RoomType::find($id);
    $updateSuccessful->update($request->validated());
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
    $RoomType =RoomType::find($id);
    $RoomType->delete();
    return $this->api_design(200, 'RoomType deleted successfully', new RoomTypeResource($RoomType));
}
}
