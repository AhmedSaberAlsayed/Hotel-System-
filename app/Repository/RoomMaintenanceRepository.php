<?php

namespace App\Repository;

use App\Models\Room;
use App\Models\RoomMaintenance;
use App\Http\Resources\RoomTypeResource;
use App\RepositoryInterface\RoomMaintenanceRepositoryInterface;

class RoomMaintenanceRepository implements RoomMaintenanceRepositoryInterface
{
    public function all($paginate)
    {
        $room =  RoomMaintenance::with('room')->paginate($paginate);
        $data = [
            'room' => RoomTypeResource::collection($room),
            'pagination' => [
                'total' => $room->total(),
                'per_page' => $room->perPage(),
                'current_page' => $room->currentPage(),
                'total_pages' => $room->lastPage(),
                'first_page_url' => $room->url(1),
                'last_page_url' => $room->url($room->lastPage()),
                'next_page_url' => $room->nextPageUrl(),
                'prev_page_url' => $room->previousPageUrl(),
                'path' => $room->path(),
            ]
        ];
        return $data;
    }

    public function find($id)
    {
        return RoomMaintenance::with('room')->find($id);
    }

    public function create(array $data)
    {
        $maintenance =  RoomMaintenance::create($data);
        $this->updateRoomStatus($data['room_id'], 'in maintenance');

        return $maintenance;
    }

    public function update($id, array $data)
    {
        $maintenance = RoomMaintenance::find($id);
        return $maintenance->update($data);
    }

    public function delete( $id)
    {
        $maintenance = RoomMaintenance::find($id);

        $this->updateRoomStatus($maintenance['room_id'], 'open');

        return $maintenance->delete();
    }
    public function updateRoomStatus($roomId, $status)
    {
        $room = Room::find($roomId);
        if ($room) {
            $room->status = $status;
            $room->save();
        }
    }
}
