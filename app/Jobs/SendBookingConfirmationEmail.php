<?php

// app/Jobs/SendBookingConfirmationEmail.php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendBookingConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $booking;

    public function __construct($email, $booking)
    {
        $this->email = $email;
        $this->booking = $booking;
    }

    public function handle()
    {
        Mail::to($this->email)->send(new BookingConfirmationMail($this->booking));
    }
}
