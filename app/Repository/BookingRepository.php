<?php

namespace App\Repository;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceUsage;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Api_designtrait;
use App\RepositoryInterface\BookingRepositoryInterface;

class BookingRepository implements BookingRepositoryInterface
{
    use Api_designtrait;
    public function all($paginate) {}
    public function find($id) {}
    public function create($request, $booking) {
        DB::beginTransaction();

        try {
        $activeBooking = Booking::where('GuestID', $request->GuestID)
        ->where('CheckOutDate', '>=', Carbon::now())
        ->exists();

if ($activeBooking) {
    return $this->api_design(400, 'ou cannot make a new booking until your current booking has ended',null,);
}

            $services = $request->services;
            $totalPrice= $this->HandelServices($services);
            $booking->GuestID = $request->GuestID;
            $booking->RoomID = $request->RoomID;
            $booking->SpecialRequests = $request->SpecialRequests;
            $booking->BookingStatus = $request->BookingStatus;
            $booking->PaymentStatus = $request->PaymentStatus;
            $booking->BookingDate = Carbon::now();
            $booking->CheckOutDate = $request->CheckOutDate;
            $booking->CheckInDate = $request->CheckInDate;
            $roomCost = $booking->calculateRoomCost();
            $totalPrice += $roomCost;
            $booking->TotalPrice = $totalPrice;
            $booking->save();
            $this->storeServiceUsage($services,$booking->BookingID );
            DB::commit();
            return $booking;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function update($id, array $data) {}
    public function delete($id) {}

    public function HandelServices($services){
        foreach ($services as $service) {
            $serviceInstance = Service::find($service['ServiceID']);
            $totalPrice = 0;
            if ($serviceInstance) {
                $serviceTotalPrice = $service['quantity'] * $serviceInstance->ServicePrice;
                $totalPrice += $serviceTotalPrice;
            }
        }
        return $totalPrice;
    }
    public function storeServiceUsage($serviceUsage , $bookingid){
        foreach ($serviceUsage as $service) {
            $serviceInstance = Service::find($service['ServiceID']);

            if ($serviceInstance) {
                $serviceUsage = new ServiceUsage([
                    'BookingID' => $bookingid,
                    'ServiceID' => $service['ServiceID'],
                    'Quantity' => $service['quantity'],
                    // 'StaffID' => 3,
                    'UsageDate' => Carbon::now(),
                    'TotalCost' => $service['quantity'] * $serviceInstance->ServicePrice,
                ]);
                $serviceUsage->save();
            }
        }
    }
}
