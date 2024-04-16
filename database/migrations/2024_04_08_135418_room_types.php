<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoomTypes extends Migration
{
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
        });

        DB::table('room_types')->insert(
            array(
                ['type' => 'Стандартний'],
                ['type' => 'Люкс'],
                ['type' => 'Двомісний'],
                ['type' => 'Одномісний']
            )
        );
    }

    public function down()
    {
        Schema::dropIfExists('room_types');
    }
}
