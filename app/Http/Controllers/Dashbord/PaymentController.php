<?php

namespace App\Http\Controllers\Dashbord;

use Stripe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\RepositoryInterface\PaymentRepositoryInterface;

class PaymentController extends Controller
{
    use Api_designtrait;
    protected $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $userId = Auth()->user();
        $customer = Stripe\Customer::create([
            "address" => [
                "line1" => "Virani Chowk",
                "postal_code" => "360001",
                "city" => "Rajkot",
                "state" => "GJ",
                "country" => "IN",
            ],
            "email" => $userId->Email,
            "name" => $userId->FirstName . ' ' . $userId->LastName,
            "source" => "tok_visa",
        ]);

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

        $payment = $this->paymentRepository->create([
            'BookingID' => 1,
            'PaymentDate' => Carbon::now(),
            'Amount' => $charge->amount,
            'PaymentMethod' => "Credit Card",
            'PaymentStatus' => $charge->status,
            'InvoiceNumber' => $charge->id,
        ]);
        return $this->api_design( 200, ' payment Added succesully ', new PaymentResource($payment));

    }

    public function index()
    {
        $payments = $this->paymentRepository->all();
        return $this->api_design( 200, 'All payments ', new PaymentResource($payments));
    }

    public function store(PaymentRequest $request)
    {
        $payment = $this->paymentRepository->create($request->validated());
        return $this->api_design( 200, ' payment Add succsfuly ', new PaymentResource($payment));

    }

    public function show($id)
    {
        $payment = $this->paymentRepository->find($id);

        if (!$payment) {
            return $this->api_design( 404, 'Payment not found');
        }
        return $this->api_design( 200, 'your payment ', new PaymentResource($payment));

    }

    public function update(PaymentRequest $request, $id)
    {
        $payment = $this->paymentRepository->update($id, $request->validated());

        if (!$payment) {
            return $this->api_design( 404, 'Payment not found');
        }
        return $this->api_design( 200, ' payment updated Succesfully ', new PaymentResource($payment));
    }

    public function destroy($id)
    {
        $payment = $this->paymentRepository->delete($id);

        if (!$payment) {
            return $this->api_design( 404, 'Payment not found');
        }
        return $this->api_design( 200, 'Payment deleted successfully ', new PaymentResource($payment));
    }
}
