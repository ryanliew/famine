<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hungry_count')->default(0);
            $table->integer('flag_timer')->default(3);
            $table->integer('gate_timer')->default(5);
            $table->integer('gate_gap_timer')->default(20);
            $table->timestamps();
        });

        DB::table('games')->insert([[]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
