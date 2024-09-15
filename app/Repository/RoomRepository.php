<?php

namespace App\Repository;

use App\Models\Room;
use App\ReposatoryInterface\RoomRepositoryInterface;

class RoomRepository implements RoomRepositoryInterface
{
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
