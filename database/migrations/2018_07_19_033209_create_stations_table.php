<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('answer');
            $table->string('color_first');
            $table->string('color_second');
            $table->timestamps();
        });


        DB::table('stations')->insert([
            ["answer" => "droplet", "color_first" => "red", "color_second" => "green"],
            ["answer" => "black", "color_first" => "yellow", "color_second" => "blue"],
            ["answer" => "nutrients", "color_first" => "green", "color_second" => "black"],
            ["answer" => "fall", "color_first" => "blue", "color_second" => "red"],
            ["answer" => "west", "color_first" => "black", "color_second" => "yellow"]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stations');
    }
}
