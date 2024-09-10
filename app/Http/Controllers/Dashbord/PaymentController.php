<?php

namespace App\Http\Controllers\Dashbord;


use Stripe;
use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function stripePost(Request $request)
    {
        // Assume the current user ID is retrieved from the request
        // $userId = Auth::user()->id;

        // Set the Stripe API key
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a customer in Stripe and associate your user ID in the metadata
        $userId = Auth()->user();
        $customer = Stripe\Customer::create(array(

            "address" => [

                    "line1" => "Virani Chowk",

                    "postal_code" => "360001",

                    "city" => "Rajkot",

                    "state" => "GJ",

                    "country" => "IN",
                ],

            "email" => $userId->Email,

            "name" => $userId->FirstName + $userId->LastName,
                "source" => "tok_visa",
        ));
        // Create a charge
        $charge = Stripe\Charge::create([
            "amount" => $request->input('amount') * 100,
            "currency" => $request->input('currency'),
            "customer" => $customer->id,
            "description" => $request->input('description'),
            "shipping" => [
                "name" => $request->input('shipping_name'),
                "address" => [
                    "line1" => $request->input('shipping_line1'),
                    "postal_code" => $request->input('shipping_postal_code'),
                    "city" => $request->input('shipping_city'),
                    "state" => $request->input('shipping_state'),
                    "country" => $request->input('shipping_country'),
                ],
            ]
        ]);
        $payment = Payment::create([
        'BookingID'=> 1 ,
        'PaymentDate'=> Carbon::now(),
        'Amount'=>$charge->amount,
        'PaymentMethod'=>"Credit Card",
        'PaymentStatus' => $charge->status,
        'InvoiceNumber' => $charge->id,
        ]);
        // Return a JSON response with the payment details
        return response()->json(['success' => true, 'payment' => $payment]);
    }

/**
     * Display a listing of the payments.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $payments = Payment::with('room','guest')->get();
        return response()->json($payments,  );
    }
    public function store(PaymentRequest $request)
    {
        DB::beginTransaction();

        try {
            $payment = Payment::create($request->validated());
            DB::commit();

            return response()->json($payment,);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment creation failed'], );
        }
    }

    /**
     * Display the specified payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $payment = Payment::with('reservation.customer')->find($id);

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'],  );
        }

        return response()->json($payment,  );
    }

    /**
     * Update the specified payment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PaymentRequest $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'],  );
        }

        DB::beginTransaction();

        try {
            $payment->update($request->validated());

            // Example of broadcasting an event (if needed)
            // event(new PaymentUpdated($payment));

            DB::commit();

            return response()->json($payment,  );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment update failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment update failed'], );
        }
    }

    /**
     * Remove the specified payment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'],  );
        }

        DB::beginTransaction();

        try {
            $payment->delete();

            // Example of broadcasting an event (if needed)
            // event(new PaymentDeleted($payment));

            DB::commit();

            return response()->json(['message' => 'Payment deleted successfully'],  );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment deletion failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment deletion failed'], );
        }
    }

}
