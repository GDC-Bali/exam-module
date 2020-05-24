<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleToAttempt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_attempt', function (Blueprint $table) {
            $table->string('title', 255)->nullable()->after('user_id');
            $table->string('subtitle', 255)->nullable()->after('title');
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
            $table->dropColumn('title');
            $table->dropColumn('subtitle');
        });
    }
}
