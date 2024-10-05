<?php

namespace App\Http\Controllers\Dashbord;

use Stripe;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        try {
            // Initiating the Stripe payment process by calling the repository
            $paymentData = $this->paymentRepository->stripe($request->all());

            // Return the checkout URL and the payment details
            return $this->api_design(200, 'Payment added successfully', [
                'checkout_url' => $paymentData['checkout_url'],
                'payment' => new PaymentResource($paymentData['payment'])
            ]);

        } catch (\Exception $e) {
            // Log the error and return a failure response
            Log::error('Payment initiation failed: ' . $e->getMessage());
            return $this->api_design(500, 'Payment initiation failed',null, $e->getMessage());
        }
    }


    public function index()
    {
        $payments = $this->paymentRepository->all();
        return $this->api_design( 200, 'All payments ', new PaymentResource($payments));
    }

    public function store(PaymentRequest $request)
    {
        $payment = $this->paymentRepository->create($request->all());
        return  $payment;
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


    public function handleSuccess(Request $request)
    {
        try {
            $payment = $this->paymentRepository->handleSuccess($request->all());
            return $this->api_design( 200, "payment paid succussfuly", new PaymentResource($payment));

        } catch (\Exception $e) {
            Log::error('Payment handling failed: ' . $e->getMessage());
            return $this->api_design( 500, "Failed to handle payment", null , $e->getMessage());
        }
    }
}
