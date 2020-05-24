<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributesOnQuestionGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_question_group', function (Blueprint $table) {
            $table->integer('attempt_allowed')->default(0)->after('availability');
            $table->string('access_code', 255)->nullable()->after('availability');
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
            $table->dropColumn('attempt_allowed');
            $table->dropColumn('access_code');
        });
    }
}
