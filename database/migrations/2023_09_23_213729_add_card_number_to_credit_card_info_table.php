<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCardNumberToCreditCardInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credit_card_info', function (Blueprint $table) {
            $table->string('card_number')->nullable(); // Add the card_number field
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credit_card_info', function (Blueprint $table) {
            $table->dropColumn('card_number'); // Rollback: remove the card_number field
        });
    }
}
