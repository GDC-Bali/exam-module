<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDurationAttempt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_attempt', function (Blueprint $table) {
            $table->integer('duration')->nullable()->after('subtitle');
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
            $table->dropColumn('duration');
        });
    }
}
