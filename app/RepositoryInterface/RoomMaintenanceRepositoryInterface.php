<?php

namespace App\RepositoryInterface;


interface RoomMaintenanceRepositoryInterface
{
    public function all($paginate);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function updateRoomStatus($roomId, $status);
}
