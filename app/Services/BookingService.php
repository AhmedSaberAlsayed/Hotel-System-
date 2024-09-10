<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceUsage;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Api_designtrait;

class BookingService
{
    use Api_designtrait;
    public function store($request, $booking)
    {
        DB::beginTransaction();

        try {
               // Check if the guest has an active booking
        $activeBooking = Booking::where('GuestID', $request->GuestID)
        ->where('CheckOutDate', '>=', Carbon::now())
        ->exists();

if ($activeBooking) {
    return $this->api_design(400, 'ou cannot make a new booking until your current booking has ended',null,);
}

            $totalPrice = 0;
            $services = $request->services;
            foreach ($services as $service) {
                $serviceInstance = Service::find($service['ServiceID']);

                if ($serviceInstance) {
                    $serviceTotalPrice = $service['quantity'] * $serviceInstance->ServicePrice;
                    $totalPrice += $serviceTotalPrice;
                }
            }

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

            foreach ($services as $service) {
                $serviceInstance = Service::find($service['ServiceID']);

                if ($serviceInstance) {
                    $serviceUsage = new ServiceUsage([
                        'BookingID' => $booking->BookingID,
                        'ServiceID' => $service['ServiceID'],
                        'Quantity' => $service['quantity'],
                        'UsageDate' => Carbon::now(),
                        'StaffID' => $request->StaffID,
                        'TotalCost' => $service['quantity'] * $serviceInstance->ServicePrice,
                    ]);
                    $serviceUsage->save();
                }
            }

            DB::commit();
            return $booking;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
