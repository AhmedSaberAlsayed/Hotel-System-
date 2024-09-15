<?php 
namespace App\Repository;

use App\Models\RoomType;
use Illuminate\Support\Facades\Hash;
use App\ReposatoryInterface\RoomTypeRepositoryInterface;

class RoomTypeRepository implements RoomTypeRepositoryInterface{
    public function all($paginate){
        return RoomType::paginate($paginate);
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
            $data['Password'] = Hash::make($data['Password']);
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