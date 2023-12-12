<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColumnToVitalsMaster extends Migration
{
    public function up()
    {
        Schema::table('vitals_master', function (Blueprint $table) {
            $table->string('type')->nullable(); // Adding a nullable 'type' column
        });
    }

    public function down()
    {
        Schema::table('vitals_master', function (Blueprint $table) {
            $table->dropColumn('type'); // Dropping the 'type' column
        });
    }
}
