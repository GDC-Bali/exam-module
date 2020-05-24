<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowNullTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_question_category', function (Blueprint $table) {
            $table->text('desc')->nullable()->change();
        });

        Schema::table('ms_question', function (Blueprint $table) {
            $table->text('additional_note')->nullable()->change();
        });

        Schema::table('ms_question_group', function (Blueprint $table) {
            $table->text('desc')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
