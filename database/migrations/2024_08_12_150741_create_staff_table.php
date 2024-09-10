<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id('StaffID');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Position');
            $table->string('Email')->unique();
            $table->string('Phone');
            $table->string('Address');
            $table->decimal('Salary', 8, 2);
            $table->foreignId('DepartmentID')->references('DepartmentID')->on('departments');
            $table->foreignId('SupervisorID')->nullable()->on('staff');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
