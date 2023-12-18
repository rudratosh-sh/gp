<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('presenting_complaints')->nullable();
            $table->text('relevant_history')->nullable();
            $table->text('examination')->nullable();
            $table->text('recommendation')->nullable();
            $table->text('followup')->nullable();
            $table->text('personalization_framework')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
