<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTableV2 extends Migration
{
    public function up()
    {
        Schema::create('options_v2', function (Blueprint $table) {
            $table->id('option_id');
            $table->foreignId('question_id')->constrained('questions_v2');
            $table->text('option_text');
            $table->boolean('is_correct')->nullable(); // For MCQs and Multi-select
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('options_v2');
    }
}
