<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('user_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('latitude', 10, 6); // Latitude value with 10 digits, 6 decimal places
            $table->double('longitude', 10, 6); // Longitude value with 10 digits, 6 decimal places
            $table->string('location_name'); // Add location name column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_locations');
    }
}

