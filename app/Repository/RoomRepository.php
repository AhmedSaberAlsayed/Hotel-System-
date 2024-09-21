<?php

namespace App\Repository;

use App\Models\Room;
use App\Http\Resources\RoomResource;
use App\RepositoryInterface\RoomRepositoryInterface;

class RoomRepository implements RoomRepositoryInterface
{

    public function all($paginate)
    {
        $room =  Room::with('roomType')->paginate($paginate);
        $data = [
            'room' => RoomResource::collection($room),
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
    public function create(array $data)
    {
        return Room::create($data);
    }

    public function find($id)
    {
        return Room::find($id);
    }

    public function update($id, array $data)
    {
        $Room = Room::find($id);
        if ($Room) {
            $Room->update($data);
        }
        return $Room;
    }

    public function delete($id)
    {
        $Room =Room::find($id);
        $oldfile = $Room->image;
        $oldfilePath = public_path($oldfile);
        unlink($oldfilePath);
        $Room->delete();
        return $Room;
    }
}
