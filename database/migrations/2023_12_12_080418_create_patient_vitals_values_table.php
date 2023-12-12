<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientVitalsValuesTable extends Migration
{
    public function up()
    {
        Schema::create('patient_vitals_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_vital_id');
            $table->unsignedBigInteger('user_id');
            $table->string('value'); // The actual value of the vital
            // Foreign key constraint for user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_vitals_values');
    }
}
