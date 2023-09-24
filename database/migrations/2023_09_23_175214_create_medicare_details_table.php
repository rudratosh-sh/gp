<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicareDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('medicare_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('medicare_number')->unique();
            $table->string('gender');
            $table->date('birthdate');
            $table->string('medicare_image');
            $table->string('address');
            // Add other columns for Medicare details
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicare_details');
    }
}
