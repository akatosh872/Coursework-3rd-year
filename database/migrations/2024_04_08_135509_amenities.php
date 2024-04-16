<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Amenities extends Migration
{
    public function up()
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('amenity');
            $table->timestamps();
        });

        DB::table('amenities')->insert(
            array(
                ['amenity' => 'Кондиціонер'],
                ['amenity' => 'Wi-Fi'],
                ['amenity' => 'Телевізор'],
                ['amenity' => 'Тераса']
            )
        );
    }

    public function down()
    {
        Schema::dropIfExists('amenities');
    }
}
