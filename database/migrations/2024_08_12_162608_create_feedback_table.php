<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('FeedbackID');
            $table->foreignId('GuestID')->references('GuestID')->on('guests');
            $table->foreignId('BookingID')->references('BookingID')->on('bookings');
            $table->integer('Rating');
            $table->text('Comments')->nullable();
            $table->dateTime('FeedbackDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
