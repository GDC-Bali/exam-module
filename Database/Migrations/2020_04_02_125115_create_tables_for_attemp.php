<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesForAttemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_attempt', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('question_group_id');
            $table->foreign('question_group_id')->references('id')->on('ms_question_group');
            $table->integer('no_attempt')->unsigned();
            $table->date('date');
            $table->time('start_time');
            $table->time('finish_time');
            $table->tinyInteger('status');
            $table->integer('question_total')->unsigned();
            $table->decimal('grade', 10, 2);
            $table->timestamps();
        });

        Schema::create('ms_attempt_answer', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('attempt_id');
            $table->foreign('attempt_id')->references('id')->on('ms_attempt');
            $table->uuid('question_id');
            $table->foreign('question_id')->references('id')->on('ms_question');
            $table->uuid('question_option_id')->nullable();
            $table->foreign('question_option_id')->nullable()->references('id')->on('ms_question_option');
            $table->text('answer');
            $table->decimal('point', 10, 2);
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
        Schema::dropIfExists('ms_attempt_answer');
        Schema::dropIfExists('ms_attempt');
    }
}
