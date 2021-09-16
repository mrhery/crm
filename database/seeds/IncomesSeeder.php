<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incomes')->insert([
            [
                'id' => 1,
                'range' => 'Kurang RM1000'
            ],
            [
                'id' => 2,
                'range' => 'RM1000 - RM5000'
            ],
            [
                'id' => 3,
                'range' => 'RM5000 - RM10000'
            ],
            [
                'id' => 4,
                'range' => 'RM10000 - RM15000'
            ],
            [
                'id' => 5,
                'range' => 'RM15000 - RM20000'
            ],
            [
                'id' => 6,
                'range' => 'Lebih RM20000'
            ]
        ]);
    }
}
