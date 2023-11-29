<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUserIdFromMessagesTable extends Migration
{
    public function up()
    {
        // Drop the foreign key constraint
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_user_id_foreign');
        });

        // Then remove the column
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }

    public function down()
    {
        // If you need to rollback, add the user_id column back
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->nullable();
        });
    }
}

