<?php

namespace App\Http\Controllers\Dashbord\Rooms;

use App\Http\Traits\ImagesTrait;
use App\Http\Requests\RoomRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Http\Traits\Api_designtrait;
use App\ReposatoryInterface\RoomRepositoryInterface;

class RoomController extends Controller
{
    use ImagesTrait;
    use Api_designtrait;

    protected $roomRepository;

    public function __construct(RoomRepositoryInterface $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function store(RoomRequest $request)
    {
        $filename = time() . '.' . $request->image->getClientOriginalExtension();
        $this->uploadimg($request->image, $filename, "Rooms");

        $data = $request->all();
        $data['image'] = $filename;

        $Room = $this->roomRepository->create($data);

        return $this->api_design(201, 'Room added successfully', new RoomResource($Room));
    }

    public function show($id)
    {
        $Room = $this->roomRepository->find($id);
        return $this->api_design(200, 'Selected Room', new RoomResource($Room));
    }

    public function update(RoomRequest $request, $id)
    {
        $Room = $this->roomRepository->find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();

            // Remove the old image and upload the new one
            $this->uploadimg($image, $fileName, 'Rooms', $Room->image);
        } else {
            $fileName = $Room->image;
        }

        $data = $request->all();
        $data['image'] = $fileName;

        $updatedRoom = $this->roomRepository->update($id, $data);

        if ($updatedRoom) {
            return $this->api_design(200, 'Room updated successfully', new RoomResource($updatedRoom));
        }

        return $this->api_design(500, 'Room update failed');
    }

    public function destroy($id)
    {
        $Room = $this->roomRepository->delete($id);

        return $this->api_design(200, 'Room deleted successfully', new RoomResource($Room));
    }
}
