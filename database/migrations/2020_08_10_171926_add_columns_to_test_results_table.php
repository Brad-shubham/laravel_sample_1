<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropForeign('test_results_test_answer_id_foreign');
            $table->dropColumn('test_answer_id');

            $table->unsignedBigInteger('student_id')->after('id');
            $table->foreign('student_id')->references('id')->on('users');
            $table->unsignedBigInteger('test_id')->after('student_id');
            $table->foreign('teacher_id')->references('id')->on('users');
            $table->unsignedBigInteger('teacher_id')->after('test_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropForeign('test_results_student_id_foreign');
            $table->dropColumn('student_id');
            $table->dropForeign('test_results_teacher_id_foreign');
            $table->dropColumn('teacher_id');

            $table->unsignedBigInteger('test_answer_id')->after('id');
            $table->foreign('test_answer_id')->references('id')->on('test_answers');
        });
    }
}
