<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignupStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('signup_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // Associate each status with a user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('basic_details')->default(false);
            $table->boolean('otp_verification')->default(false);
            $table->boolean('medicare_card_verification')->default(false);
            $table->boolean('card_details_verification')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('signup_statuses');
    }
}

