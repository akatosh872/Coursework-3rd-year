<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rooms extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unsigned();
            $table->foreignId('hotel_id')->constrained('hotels');
            $table->foreignId('type_id')->constrained('room_types');
            $table->integer('beds')->unsigned();
            $table->decimal('square_meters', 8, 2);
            $table->decimal('price_per_night', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
