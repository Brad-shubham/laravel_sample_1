<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestQuestionOptionsMultilingualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_question_options_multilingual', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->boolean('is_answer');

            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')->references('id')->on('test_question_options')->onDelete('cascade');

            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

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
        Schema::dropIfExists('test_question_options_multilingual');
    }
}
