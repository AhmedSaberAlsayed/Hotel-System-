<?php

namespace App\RepositoryInterface;

interface PaymentRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function stripe(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function handleSuccess($id);

}
