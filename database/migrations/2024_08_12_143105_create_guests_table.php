<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsTable extends Migration
{
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id('GuestID');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Email')->unique();
            $table->string('Phone');
            $table->string('Password');
            $table->string('Address');
            $table->date('DateOfBirth');
            $table->string('socialID')->nullable();
            $table->string('socialType')->nullable();
            $table->integer('LoyaltyPoints')->default(0);
            $table->string('MembershipLevel')->default('Bronze');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guests');
    }
}

