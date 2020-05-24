<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnGradeFormula extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_question_group', function (Blueprint $table) {
            $table->integer('grade_formula')->after('attempt_allowed');
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
            $table->deleteColumn('grade_formula');
        });
    }
}
