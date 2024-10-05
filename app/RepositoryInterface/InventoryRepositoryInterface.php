<?php 

namespace App\RepositoryInterface;

interface InventoryRepositoryInterface
{
    public function getAll($paginate);
    public function findById($id);
    public function create( $data);
    public function update($id, array $data);
    public function delete($id);
}