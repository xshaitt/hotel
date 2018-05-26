<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hotelId')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('enName')->nullable();
            $table->string('address')->nullable();
            $table->string('starRate')->nullable();
            $table->string('category')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('establishmentDate')->nullable();
            $table->string('renovationDate')->nullable();
            $table->string('baiduLat')->nullable();
            $table->string('baiduLon')->nullable();
            $table->string('city')->nullable();
            $table->string('businessZone')->nullable();
            $table->string('district')->nullable();
            $table->string('landmarks')->nullable();
            $table->text('introEditor')->nullable();
            $table->string('description')->nullable();
            $table->string('airportPickUpService')->nullable();
            $table->string('generalAmenities')->nullable();
            $table->string('roomAmenities')->nullable();
            $table->text('images')->nullable();
            $table->string('thumbnailId')->nullable();
            $table->string('updateTime')->nullable();
            $table->string('commentScore')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
