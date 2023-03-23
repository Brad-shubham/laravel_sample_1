<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_profile', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('profile_image')->nullable();
            $table->year('birth_year')->nullable();
            $table->unsignedSmallInteger('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries');

            $table->string('private_mail_po_number')->nullable();
            $table->string('org_po_number')->nullable();
            $table->string('designation')->nullable();
            $table->unsignedBigInteger('postal_code_id')->nullable();
            $table->foreign('postal_code_id')->references('id')->on('postal_code');

            $table->date('encouragement_card_sent')->nullable();
            $table->boolean('prisoner')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('religion')->nullable();
            $table->unsignedBigInteger('course_language_id')->nullable();
            $table->foreign('course_language_id')->references('id')->on('languages');

            $table->date('date_enrolled')->nullable();
            $table->date('last_test')->nullable();
            $table->string('activity_status')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_profile');
    }
}
