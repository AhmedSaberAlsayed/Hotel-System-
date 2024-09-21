<?php

namespace App\RepositoryInterface;

interface RoomRepositoryInterface{
    public function all($data);
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
