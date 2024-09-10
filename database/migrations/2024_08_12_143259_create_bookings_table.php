<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('BookingID');
            $table->foreignId('GuestID')->references('GuestID')
            ->on('guests');
            $table->foreignId('RoomID')->references('RoomID')
            ->on('rooms');
            $table->date('CheckInDate');
            $table->date('CheckOutDate');
            $table->date('BookingDate');
            $table->decimal('TotalPrice', 8, 2);
            $table->string('PaymentStatus');
            $table->string('BookingStatus');
            $table->text('SpecialRequests')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
