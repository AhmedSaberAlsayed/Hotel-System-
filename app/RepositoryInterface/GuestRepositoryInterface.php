<?php

namespace App\ReposatoryInterface;

interface GuestRepositoryInterface
{
    public function all($paginate);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findByEmail($email);
}
