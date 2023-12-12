<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastVisitedToAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->timestamp('last_visited')->nullable()->after('clinic_id');
            // Change 'clinic_id' to the column after which you want to add this new column
            // This assumes that 'clinic_id' is an existing column in the 'appointments' table
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('last_visited');
        });
    }
}
