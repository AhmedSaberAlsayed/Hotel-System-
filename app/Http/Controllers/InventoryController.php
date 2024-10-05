<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\RepositoryInterface\InventoryRepositoryInterface;

class InventoryController extends Controller
{
    protected $inventoryRepository;

    public function __construct(InventoryRepositoryInterface $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    // Display a listing of the inventory items
    public function index()
    {
        $inventories = $this->inventoryRepository->getAll(10);
        return response()->json($inventories, 200);
    }

    // Store a newly created inventory in storage
    public function store(InventoryRequest $request)
    {
        $data = $request->validated();
        $inventory = $this->inventoryRepository->create($data);
        return response()->json($inventory, 201);
    }

    // Display the specified inventory item
    public function show($id)
    {
        $inventory = $this->inventoryRepository->findById($id);

        if (!$inventory) {
            return response()->json(['message' => 'Inventory not found'], 404);
        }

        return response()->json($inventory, 200);
    }

    // Update the specified inventory in storage
    public function update(InventoryRequest $request, $id)
    {
        $data = $request->validated();
        $updatedInventory = $this->inventoryRepository->update($id, $data);

        if (!$updatedInventory) {
            return response()->json(['message' => 'Inventory not found or update failed'], 404);
        }

        return response()->json($updatedInventory, 200);
    }

    // Remove the specified inventory from storage
    public function destroy($id)
    {
        $deleted = $this->inventoryRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Inventory not found or deletion failed'], 404);
        }

        return response()->json(['message' => 'Inventory deleted successfully'], 200);
    }
}
