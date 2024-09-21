<?php

namespace App\RepositoryInterface;

interface ServiceRepositoryInterface
{
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
