<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceUsagesTable extends Migration
{
    public function up()
    {
        Schema::create('service_usages', function (Blueprint $table) {
            $table->id('ServiceUsageID');
            $table->foreignId('BookingID')->references('BookingID')->on('bookings');
            $table->foreignId('ServiceID')->references('ServiceID')->on('services');
            $table->foreignId('StaffID')->references('StaffID')->on('staff')->nullable();
            $table->date('UsageDate');
            $table->integer('Quantity')->default(1);
            $table->decimal('TotalCost', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_usages');
    }
}
