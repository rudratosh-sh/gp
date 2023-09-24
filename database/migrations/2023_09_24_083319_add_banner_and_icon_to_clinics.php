<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('clinics', function (Blueprint $table) {
            // Add banner image column
            $table->string('banner_image')->nullable();

            // Add profile icon column
            $table->string('profile_icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('clinics', function (Blueprint $table) {
            // Remove banner image and profile icon columns
            $table->dropColumn('banner_image');
            $table->dropColumn('profile_icon');
        });
    }
};
