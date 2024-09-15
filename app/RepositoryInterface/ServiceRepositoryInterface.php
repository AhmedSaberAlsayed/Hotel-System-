<?php

namespace App\ReposatoryInterface;

interface ServiceRepositoryInterface
{
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
