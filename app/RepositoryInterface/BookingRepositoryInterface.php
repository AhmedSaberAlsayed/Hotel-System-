<?php

namespace App\RepositoryInterface;


interface BookingRepositoryInterface
{
    public function all($paginate);
    public function find($id);
    public function create($request, $data);
    public function update($id, array $data);
    public function delete($id);
}
