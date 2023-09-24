<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditCardInfoTable extends Migration
{
    public function up()
    {
        Schema::create('credit_card_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('last_four_digits'); // Store the last four digits securely
            $table->string('expiration_month');
            $table->string('expiration_year');
            $table->timestamps();

            // Add foreign key constraint to the user table
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_card_info');
    }
}
