<?php

namespace App\Repository;

use Stripe;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\RepositoryInterface\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function all()
    {
        return Payment::with('room', 'guest')->get();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $booking = Booking::where("BookingID",$data["BookingID"])
            ->where("PaymentStatus","not paid")->first();
            $amount = $booking->TotalPrice;
            // dd($amount);
            $payment = Payment::create([
        'BookingID' => $data["BookingID"],
        'PaymentDate'=>Carbon::now()->format('Y-m-d'),
        'Amount'=> $amount,
        'PaymentMethod'=> "cash",
        'PaymentStatus'=> "paid",
        'InvoiceNumber'=> $data["InvoiceNumber"],
            ]);
            $this->handelBookingStatus($booking->BookingID);
            DB::commit();
            return $payment;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function handelBookingStatus($id){
        $booking = Booking::find($id);
        $booking->update([
            "PaymentStatus" => "paid",
        ]);

    }







    public function find($id)
    {
        return Payment::with('reservation.customer')->find($id);
    }

    public function update($id, array $data)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return null;
        }

        DB::beginTransaction();
        try {
            $payment->update($data);
            DB::commit();
            return $payment;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment update failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return null;
        }

        DB::beginTransaction();
        try {
            $payment->delete();
            DB::commit();
            return $payment;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment deletion failed: ' . $e->getMessage());
            throw $e;
        }
    }


    public function stripe($data)
    {
        DB::beginTransaction();
        try {
            // Set Stripe API key
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            
            // Get the authenticated user (guest)
            $guest = Auth()->user();
    
            // Retrieve the booking details
            $booking = Booking::where('BookingID', $data['BookingID'])
                    ->where('PaymentStatus', 'not paid')
                    ->first();
            
            if (!$booking) {
                throw new \Exception('Booking not found or already paid.');
            }
    
            $amount = $booking->TotalPrice;
    
            // Create a Stripe customer
            $customer = Stripe\Customer::create([
                "email" => $guest->Email,
                "name" => $guest->FirstName . ' ' . $guest->LastName,
            ]);
    
            // Create the Stripe Checkout session
            $checkoutSession = Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'customer' => $customer->id,
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'EGP',
                        'product_data' => [
                            'name' => 'Booking Payment',
                        ],
                        'unit_amount' => $amount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['BookingID' => $data['BookingID']]),
                'cancel_url' => route('payment.cancel'),
            ]);
    
            // Create a new payment record
            $payment = Payment::create([
                'BookingID' => $data['BookingID'],
                'PaymentDate' => Carbon::now()->format('Y-m-d'),
                'Amount' => $amount,
                'PaymentMethod' => "Credit Card",
                'PaymentStatus' => "pending",
                'InvoiceNumber' => $checkoutSession->id,
            ]);
    
            // Commit the transaction
            DB::commit();
    
            // Return the checkout session for redirection in the response
            return [
                'checkout_url' => $checkoutSession->url,
                'payment' => $payment,
            ];
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment creation failed: ' . $e->getMessage());
            throw $e;
        }
    }
    public function handleSuccess($data){

    $bookingID = $data['BookingID'];

        $booking = Booking::where('BookingID', $bookingID)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
          }

          $payment = Payment::where('BookingID', $bookingID)
          ->first();

          if ($payment) {
            $payment->PaymentStatus = 'paid';
            $payment->Amount = $payment->Amount / 100; 
            $payment->save();

            $booking->PaymentStatus = 'paid';
            $booking->save();

              

              return $payment;
          }

          return response()->json(['message' => 'Payment record not found'], 404);
    }

}
