<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id('ServiceID');
            $table->string('ServiceName');
            $table->text('ServiceDescription');
            $table->decimal('ServicePrice', 8, 2);
            $table->string('ServiceCategory');
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
}
