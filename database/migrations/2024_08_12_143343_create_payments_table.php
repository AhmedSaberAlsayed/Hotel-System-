<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('PaymentID');
            $table->foreignId('BookingID')->references('BookingID')->on('bookings');
            $table->date('PaymentDate');
            $table->decimal('Amount', 8, 2);
            $table->string('PaymentMethod');
            $table->string('PaymentStatus');
            $table->string('InvoiceNumber')->nullable();
            $table->timestamps();
        });
    }




    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
