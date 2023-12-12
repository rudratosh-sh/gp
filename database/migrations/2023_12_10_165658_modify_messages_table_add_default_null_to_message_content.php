<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMessagesTableAddDefaultNullToMessageContent extends Migration
{
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->text('message_content')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->text('message_content')->nullable(false)->change();
        });
    }
}
