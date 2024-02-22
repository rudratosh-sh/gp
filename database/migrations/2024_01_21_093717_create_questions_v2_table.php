<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTableV2 extends Migration
{
    public function up()
    {
        Schema::create('questions_v2', function (Blueprint $table) {
            $table->id('question_id');
            $table->foreignId('quiz_id')->constrained('quizzes_v2');
            $table->text('question_text');
            $table->string('question_type');
            $table->integer('order');
            $table->integer('points');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions_v2');
    }
}

