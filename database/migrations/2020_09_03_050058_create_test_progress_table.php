<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('test_id')->references('id')->on('tests')->cascadeOnDelete();
            $table->boolean('is_unlocked')->default(false);
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
        Schema::dropIfExists('test_progress');
    }
}
