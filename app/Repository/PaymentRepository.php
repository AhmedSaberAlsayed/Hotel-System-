<?php

namespace App\Repository;

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
            $payment = Payment::create($data);
            DB::commit();
            return $payment;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment creation failed: ' . $e->getMessage());
            throw $e;
        }
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
}
