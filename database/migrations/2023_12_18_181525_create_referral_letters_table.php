<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralLettersTable extends Migration
{
    public function up()
    {
        Schema::create('referral_letters', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('doctor_id');
            $table->json('attachments')->nullable(); // Modify data type as needed
            $table->string('subject');
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('doctor_id')->references('id')->on('doctors');
        });
    }

    public function down()
    {
        Schema::dropIfExists('referral_letters');
    }
}
