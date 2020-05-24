<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccessFromTo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_attempt', function (Blueprint $table) {
            $table->string('exam_type')->nullable()->after('user_id');
            $table->char('exam_id', 36)->nullable()->after('exam_type');
            $table->dateTime('valid_from')->nullable()->after('subtitle');
            $table->dateTime('valid_to')->nullable()->after('valid_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_attempt', function (Blueprint $table) {
            $table->dropColumn('valid_from');
            $table->dropColumn('valid_to');
            $table->dropColumn('exam_type');
            $table->dropColumn('exam_id');
        });
    }
}
