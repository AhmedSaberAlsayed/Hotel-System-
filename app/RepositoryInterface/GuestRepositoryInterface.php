<?php

namespace App\RepositoryInterface;

interface GuestRepositoryInterface
{
    public function all($paginate);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findByEmail($email);
    public function findBySocialID($sId);
    public function redirect();
    public function handleCallback($data,$id);
}
