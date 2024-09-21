<?php



use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('RoomID');
            $table->integer('RoomNumber');
            $table->string('image');
            $table->foreignId('RoomTypeID')->references('RoomTypeID')->on('room_types');
            $table->integer('Capacity');
            $table->decimal('PricePerNight', 8, 2);
            $table->string('Status')->default('open');
            $table->integer('Floor');
            $table->string('ViewType');
            $table->string('Features')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
