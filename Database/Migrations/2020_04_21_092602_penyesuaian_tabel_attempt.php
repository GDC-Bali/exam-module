<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PenyesuaianTabelAttempt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_attempt', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('start_time');
            $table->dropColumn('finish_time');
            $table->dateTime('start_at')->after('no_attempt');
            $table->dateTime('finish_at')->nullable()->after('start_at');
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
            $table->date('date')->after('no_attempt');
            $table->time('start_time')->after('date');
            $table->time('finish_time')->after('finish_time');
            $table->dropColumn('start_at');
            $table->dropColumn('finish_at');
        });
    }
}
