<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTableV2 extends Migration
{
    public function up()
    {
        Schema::create('quizzes_v2', function (Blueprint $table) {
            $table->id('quiz_id');
            $table->foreignId('user_id')->constrained('users');
            $table->string('quiz_name');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes_v2');
    }
}
