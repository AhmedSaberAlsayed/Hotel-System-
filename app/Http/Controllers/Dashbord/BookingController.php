<?php

namespace App\Http\Controllers\Dashbord;

use Carbon\Carbon;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Jobs\SendBookingConfirmationEmail;
use App\RepositoryInterface\BookingRepositoryInterface;

class BookingController extends Controller
{
    use Api_designtrait;
    protected $bookingRepo;

    public function __construct(BookingRepositoryInterface $bookingRepo)
    {
        $this-> bookingRepo = $bookingRepo;
    }

    public function store(BookingRequest $request, Booking $booking)
    {


        try {
            // searvice code for bookings
            $booking = $this-> bookingRepo->create($request, $booking);
            // queue code for bookings mails
            $guest = $booking->guest->Email;

        $job= (new SendBookingConfirmationEmail($guest, $booking))->delay(Carbon::now()->addSeconds(5));
            dispatch($job);

        return $this->api_design(201, 'Booking added successfully', new BookingResource($booking));

        }catch (\Exception $e) {
            return $this->api_design(500, 'Booking failed', null, $e->getMessage());
        }
    }

    public function show( $id)
    {
        $Booking = Booking::find($id);
        return $this->api_design(200, 'Selected Booking', new BookingResource($Booking));
    }

    public function update(BookingRequest $request,$id)
    {
        $updateSuccessful =Booking::find($id);
        $updateSuccessful->update($request->validated());

        if ($updateSuccessful) {
            return $this->api_design(200, 'Booking updated successfully', new BookingResource($updateSuccessful));
        }
        return $this->api_design(500, 'Booking update failed');
    }

    public function destroy($id)
    {
        $Booking =Booking::find($id);
        $Booking->delete();
        return $this->api_design(200, 'Booking deleted successfully', new BookingResource($Booking));
    }
}
