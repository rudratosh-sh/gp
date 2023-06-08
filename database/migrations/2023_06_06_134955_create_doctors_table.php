<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('speciality_id');
            $table->decimal('price', 8, 2);
            // Add other columns as needed
            $table->timestamps();

            $table->foreign('clinic_id')
                ->references('id')
                ->on('clinics')
                ->onDelete('cascade');

            $table->foreign('speciality_id')
                ->references('id')
                ->on('specialities')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
