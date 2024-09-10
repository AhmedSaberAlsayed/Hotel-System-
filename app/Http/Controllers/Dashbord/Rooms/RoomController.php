<?php

namespace App\Http\Controllers\Dashbord\Rooms;

use App\Models\Room;
use App\Http\Traits\ImagesTrait;
use App\Http\Requests\RoomRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Http\Traits\Api_designtrait;


class RoomController extends Controller
{
    use ImagesTrait;
    use Api_designtrait;
    public function store(RoomRequest $request)
{

    $filename = time() . '.' . $request->image->getClientOriginalExtension();
    $this->uploadimg($request->image,$filename,"Rooms");

    $Room = Room::create([
        'RoomNumber'=>$request->RoomNumber ,
        'RoomTypeID' =>$request->RoomTypeID ,
        'Capacity'=>$request->Capacity ,
        'PricePerNight'=>$request->PricePerNight ,
        'Status'=>$request->Status ,
        'Floor'=>$request->Floor ,
        'ViewType'=>$request->ViewType ,
        'Features'=>$request->Features ,
        'image' =>$filename
        ]);
        return $this->api_design(201, 'Room added successfully', new RoomResource($Room));
}
public function show(Room $Room)
{
    return $this->api_design(200, 'Selected Room', new RoomResource($Room));
}
public function update(RoomRequest $request,$id)
{
    $updateSuccessful =Room::find($id);
    if($request->hasFile('image')){
        $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();

            $oldImagePath =$updateSuccessful->image;

            $this->uploadimg($image, $fileName, 'Rooms', $oldImagePath);
        } else {
            $fileName = $updateSuccessful->image;
        }
    $updateSuccessful->update([
        'RoomNumber'=>$request->RoomNumber ,
        'RoomTypeID' =>$request->RoomTypeID ,
        'Capacity'=>$request->Capacity ,
        'PricePerNight'=>$request->PricePerNight ,
        'Status'=>$request->Status ,
        'Floor'=>$request->Floor ,
        'ViewType'=>$request->ViewType ,
        'Features'=>$request->Features ,
        'image' =>$fileName
        ]);
    if ($updateSuccessful) {
        return $this->api_design(200, 'Room updated successfully', new RoomResource($updateSuccessful));
    }
    return $this->api_design(500, 'Room update failed');
}

/**
 * Remove the specified staff resource from storage.
 */
public function destroy($id)
{
    $Room =Room::find($id);
    $oldfile = $Room->image;
    $oldfilePath = public_path($oldfile);
    unlink($oldfilePath);
    $Room->delete();
    return $this->api_design(200, 'Room deleted successfully', new RoomResource($Room));
}
}
