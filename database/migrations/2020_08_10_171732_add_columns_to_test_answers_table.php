<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_answers', function (Blueprint $table) {
            $table->dropForeign('test_answers_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('test_id');

            $table->unsignedBigInteger('test_result_id')->after('id');
            $table->foreign('test_result_id')->references('id')->on('test_results');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_answers', function (Blueprint $table) {
            $table->dropForeign('test_answers_test_result_id_foreign');
            $table->dropColumn('test_result_id');

            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('test_id')->after('user_id');
        });
    }
}
