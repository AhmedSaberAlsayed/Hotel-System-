<?php
namespace App\RepositoryInterface;

interface RoomTypeRepositoryInterface{

    public function all($paginate);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function find($id);

}
