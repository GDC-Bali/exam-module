<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesForQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_question_category', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type', 255);
            $table->text('desc');
            $table->timestamps();
            $table->uuid('created_by');
            $table->uuid('updated_by');
        });

        Schema::create('ms_question_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 255);
            $table->timestamps();
        });

        Schema::create('ms_question', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 255);
            $table->uuid('owner_id');
            $table->string('competencies', 255);
            $table->unsignedInteger('question_type_id');
            $table->foreign('question_type_id')->references('id')->on('ms_question_type');
            $table->boolean('randomize_option')->default(0);
            $table->boolean('single_answer')->default(1);
            $table->text('question_text');
            $table->boolean('allow_blank')->default(0);
            $table->text('additional_note');
            $table->text('feedback');
            $table->timestamps();
            $table->uuid('created_by');
            $table->uuid('updated_by');
        });

        Schema::create('ms_question_option', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('question_id');
            $table->foreign('question_id')->references('id')->on('ms_question');
            $table->text('option_text');
            $table->decimal('option_value', 5, 2);
            $table->timestamps();
        });

        Schema::create('ms_group_category', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
        });

        Schema::create('ms_question_group', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('group_name', 255);
            $table->text('desc');
            $table->string('code', 255);
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('ms_group_category');
            $table->boolean('randomize_no')->default(0);
            $table->integer('owner_id')->unsigned();
            $table->boolean('availability')->default(0);
            $table->timestamps();
            $table->uuid('created_by');
            $table->uuid('updated_by');
        });

        Schema::create('ms_group_has_question', function (Blueprint $table) {
            $table->uuid('group_id');
            $table->foreign('group_id')->references('id')->on('ms_question_group');
            $table->uuid('question_id');
            $table->foreign('question_id')->references('id')->on('ms_question');
        });

        Schema::create('ms_group_share', function (Blueprint $table) {
            $table->uuid('group_id');
            $table->foreign('group_id')->references('id')->on('ms_question_group');
            $table->uuid('user_id');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('ms_question');
        Schema::dropIfExists('ms_question_category');
        Schema::dropIfExists('ms_question_type');
        Schema::dropIfExists('ms_question_option');
        Schema::dropIfExists('ms_group_category');
        Schema::dropIfExists('ms_question_group');
        Schema::dropIfExists('ms_group_has_question');
        Schema::dropIfExists('ms_group_share');
        Schema::enableForeignKeyConstraints();
    }
}
