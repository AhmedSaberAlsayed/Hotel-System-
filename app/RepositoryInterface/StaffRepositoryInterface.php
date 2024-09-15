<?php

namespace App\RepositoryInterface;


interface StaffRepositoryInterface
{
    public function all($paginate);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
