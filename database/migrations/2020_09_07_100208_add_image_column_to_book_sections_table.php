<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageColumnToBookSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_sections', function (Blueprint $table) {
            $table->string('image')->nullable()->after('book_id');
            $table->string('image_name')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_sections', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('image_name');
        });
    }
}
