<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_data_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('temperature');
            $table->integer( 'humidity');
            $table->timestamps();
            $table->foreignId('favourite_place_id');
            $table->foreign('favourite_place_id')->references('id')
                ->on('favourite_places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_data_logs');
    }
};
