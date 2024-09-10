<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomMaintenanceTable extends Migration
{
    public function up()
    {
        Schema::create('room_maintenance', function (Blueprint $table) {
            $table->id('MaintenanceID');
            $table->foreignId('RoomID')->references('RoomID')->on('rooms');
            $table->foreignId('StaffID')->references('StaffID')->on('staff');
            $table->date('MaintenanceDate');
            $table->string('Issue');
            $table->text('Description')->nullable();
            $table->enum('Status', ['Pending', 'In Progress', 'Completed']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_maintenance');
    }
}
