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
            $table->string('Name');
            $table->string('Email')->unique();
            $table->string('Phone')->nullable();
            $table->string('Password')->nullable();
            $table->string('Address')->nullable();
            $table->string('socialID')->nullable();
            $table->enum("LoginType",["normal","social"]);
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

