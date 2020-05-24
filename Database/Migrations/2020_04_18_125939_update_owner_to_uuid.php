<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOwnerToUuid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_question_group', function (Blueprint $table) {
            $table->dropColumn('owner_id');
        });
        Schema::table('ms_question_group', function (Blueprint $table) {
            $table->uuid('owner_id')->after('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_question_group', function (Blueprint $table) {
            $table->dropColumn('owner_id');
        });

        Schema::table('ms_question_group', function (Blueprint $table) {
            $table->integer('owner_id')->after('category_id');
        });
    }
}
