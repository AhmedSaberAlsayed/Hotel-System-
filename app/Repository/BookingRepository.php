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

    public function all($paginate = null) {
        if ($paginate) {
            return Booking::paginate($paginate);
        }
        return Booking::all();
    }

    // Find a specific booking by ID
    public function find($id) {
        return Booking::find($id);
    }

    // Create a new booking
    public function create($request, $booking) {
        DB::beginTransaction();

        try {
            $activeBooking = Booking::where('GuestID', $request->GuestID)
                ->where('CheckOutDate', '>=', Carbon::now())
                ->exists();

            if ($activeBooking) {
                return $this->api_design(400, 'You cannot make a new booking until your current booking has ended', null);
            }

            $services = $request->services;
            $totalPrice = $this->HandelServices($services);
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
            $this->storeServiceUsage($services, $booking->BookingID);

            DB::commit();
            return $booking;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Update an existing booking
    public function update($id, array $data) {
        $booking = Booking::find($id);

        if (!$booking) {
            return $this->api_design(404, 'Booking not found', null);
        }

        DB::beginTransaction();

        try {
            $services = $data['services'] ?? [];
            $totalPrice = $this->HandelServices($services);

            // Update the booking fields
            $booking->GuestID = $data['GuestID'] ?? $booking->GuestID;
            $booking->RoomID = $data['RoomID'] ?? $booking->RoomID;
            $booking->SpecialRequests = $data['SpecialRequests'] ?? $booking->SpecialRequests;
            $booking->BookingStatus = $data['BookingStatus'] ?? $booking->BookingStatus;
            $booking->PaymentStatus = $data['PaymentStatus'] ?? $booking->PaymentStatus;
            $booking->CheckInDate = $data['CheckInDate'] ?? $booking->CheckInDate;
            $booking->CheckOutDate = $data['CheckOutDate'] ?? $booking->CheckOutDate;
            $roomCost = $booking->calculateRoomCost();
            $totalPrice += $roomCost;
            $booking->TotalPrice = $totalPrice;

            $booking->save();

            // Update or create service usages
            if (!empty($services)) {
                $this->storeServiceUsage($services, $booking->BookingID);
            }

            DB::commit();
            return $booking;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Delete a booking by ID
    public function delete($id) {
        $booking = Booking::find($id);

        if (!$booking) {
            return $this->api_design(404, 'Booking not found', null);
        }

        DB::beginTransaction();

        try {
            $booking->delete();
            DB::commit();
            return $this->api_design(200, 'Booking deleted successfully', null);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Helper function to calculate total price for services
    public function HandelServices($services) {
        $totalPrice = 0;
        foreach ($services as $service) {
            $serviceInstance = Service::find($service['ServiceID']);
            if ($serviceInstance) {
                $serviceTotalPrice = $service['quantity'] * $serviceInstance->ServicePrice;
                $totalPrice += $serviceTotalPrice;
            }
        }
        return $totalPrice;
    }

    // Helper function to store service usage for a booking
    public function storeServiceUsage($serviceUsage, $bookingid) {
        foreach ($serviceUsage as $service) {
            $serviceInstance = Service::find($service['ServiceID']);
            if ($serviceInstance) {
                $usage = new ServiceUsage([
                    'BookingID' => $bookingid,
                    'ServiceID' => $service['ServiceID'],
                    'Quantity' => $service['quantity'],
                    'UsageDate' => Carbon::now(),
                    'TotalCost' => $service['quantity'] * $serviceInstance->ServicePrice,
                ]);
                $usage->save();
            }
        }
    }
}
