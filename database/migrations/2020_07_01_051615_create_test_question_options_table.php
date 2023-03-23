<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_question_options', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->boolean('is_answer');

            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('test_questions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_question_options');
    }
}
