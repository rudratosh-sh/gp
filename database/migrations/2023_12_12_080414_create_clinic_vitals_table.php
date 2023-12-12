<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicVitalsTable extends Migration
{
    public function up()
    {
        Schema::create('clinic_vitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('vital_id');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('vital_id')->references('id')->on('vitals_master')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clinic_vitals');
    }
}

