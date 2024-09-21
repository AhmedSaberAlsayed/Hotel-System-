<?php
namespace App\Repository;

use App\Models\RoomType;
use App\Http\Resources\RoomTypeResource;
use App\RepositoryInterface\RoomTypeRepositoryInterface;

class RoomTypeRepository implements RoomTypeRepositoryInterface{
    public function all($paginate){
        $roomType = RoomType::paginate($paginate);
        $data = [
            'roomType' => RoomTypeResource::collection($roomType),
            'pagination' => [
                'total' => $roomType->total(),
                'count' => $roomType->count(),
                'per_page' => $roomType->perPage(),
                'current_page' => $roomType->currentPage(),
                'total_pages' => $roomType->lastPage(),
                'first_page_url' => $roomType->url(1),
                'last_page_url' => $roomType->url($roomType->lastPage()),
                'next_page_url' => $roomType->nextPageUrl(),
                'prev_page_url' => $roomType->previousPageUrl(),
                'path' => $roomType->path(),
            ]
        ];
        return $data;
    }
    public function create($data) {
        return RoomType::create($data);
    }
    public function find($id){
        return RoomType::find($id);
    }
    public function update($id, $data) {
        $roomType = RoomType::find($id);
        if ($roomType) {
            $roomType->update($data);
        }
        return $roomType;
    }
    public function delete($id) {
        $roomType = RoomType::find($id);
        if ($roomType) {
            $roomType->delete();
        }
        return $roomType;
    }
}
