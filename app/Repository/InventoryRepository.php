<?php

namespace App\Repository;

use App\Models\Inventory;
use App\Http\Resources\InventoryResource;
use App\RepositoryInterface\InventoryRepositoryInterface;

class InventoryRepository implements InventoryRepositoryInterface
{
    public function getAll($paginate)
    {
        $Inventory = Inventory::paginate($paginate);
        $data = [
            'Inventory' => InventoryResource::collection($Inventory),
            'pagination' => [
                'total' => $Inventory->total(),
                'count' => $Inventory->count(),
                'per_page' => $Inventory->perPage(),
                'current_page' => $Inventory->currentPage(),
                'total_pages' => $Inventory->lastPage(),
                'first_page_url' => $Inventory->url(1),
                'last_page_url' => $Inventory->url($Inventory->lastPage()),
                'next_page_url' => $Inventory->nextPageUrl(),
                'prev_page_url' => $Inventory->previousPageUrl(),
                'path' => $Inventory->path(),
            ]
        ];
        return $data;
    }

    public function findById($id)
    {
        return Inventory::find($id);
    }

    public function create( $data)
    {
        return Inventory::create($data);
    }

    public function update($id, array $data)
    {
        $inventory = Inventory::find($id);

        if ($inventory) {
            $inventory->update($data);
            return $inventory;
        }

        return null;
    }

    public function delete($id)
    {
        $inventory = Inventory::find($id);

        if ($inventory) {
            $inventory->delete();
            return true;
        }

        return false;
    }
}
