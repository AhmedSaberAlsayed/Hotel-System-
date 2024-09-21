<?php
namespace App\Repository;

use App\Models\Supplier;
use App\Http\Resources\SuppliersResource;
use App\RepositoryInterface\SuppliersRepositoryInterface;

class SuppliersRepository implements SuppliersRepositoryInterface
{
    public function all($paginate){
        $supplier = Supplier::with('inventory')->paginate($paginate);
        $data = [
            'supplier' => SuppliersResource::collection($supplier),
            'pagination' => [
                'total' => $supplier->total(),
                'per_page' => $supplier->perPage(),
                'current_page' => $supplier->currentPage(),
                'total_pages' => $supplier->lastPage(),
                'first_page_url' => $supplier->url(1),
                'last_page_url' => $supplier->url($supplier->lastPage()),
                'next_page_url' => $supplier->nextPageUrl(),
                'prev_page_url' => $supplier->previousPageUrl(),
                'path' => $supplier->path(),
            ]
        ];
        return $data;
    }
    public function find($id){
        return Supplier::with('inventory')->find($id);

    }
    public function create(array $data)
    {
        return Supplier::create($data);
    }

    public function update($id, array $data)
    {
        $Supplier = Supplier::find($id);
        if ($Supplier) {
            $Supplier->update($data);
        }
        return $Supplier;
    }

    public function delete($id)
    {
        $Supplier = Supplier::find($id);
        if ($Supplier) {
            $Supplier->delete();
        }
        return $Supplier;
    }
}

