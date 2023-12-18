<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOtherInfoTable extends Migration
{
    public function up()
    {
        Schema::table('other_info', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('doctor_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('other_info', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['clinic_id']);
            $table->dropForeign(['doctor_id']);

            $table->dropColumn(['user_id', 'clinic_id', 'doctor_id']);
        });
    }
}
