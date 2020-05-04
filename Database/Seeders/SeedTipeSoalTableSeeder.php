<?php

namespace Modules\Exam\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;

class SeedTipeSoalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('ms_question_type')->insert([
            ['id' => 1, 'type' => 'Pilihan Ganda'],
            ['id' => 2, 'type' => 'Essay']
        ]);
    }
}
