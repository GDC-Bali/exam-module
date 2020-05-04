<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExamRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_exam_has_question_group', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('question_group_id');
            $table->foreign('question_group_id')->references('id')->on('ms_question_group');
            $table->uuidMorphs('owner');
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
        Schema::dropIfExists('ms_exam_has_question_group');
    }
}
