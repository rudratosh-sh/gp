<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVitalsMasterTable extends Migration
{
    public function up()
    {
        Schema::create('vitals_master', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the vital (e.g., Blood Glucose, Blood Pressure)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vitals_master');
    }
}

