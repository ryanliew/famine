<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('money')->default(0);
            $table->integer('food')->default(0);
            $table->integer('water')->default(0);
            $table->timestamps();
        });

        $data = collect();

        for($i = 1; $i < 11; $i++) {
            $data->push(['money' => 0]);
        }
        DB::table('teams')->insert($data->all());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
