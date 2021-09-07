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
                'range' => 'Kurang RM5000'
            ],
            [
                'id' => 3,
                'range' => 'Kurang RM10000'
            ],
            [
                'id' => 4,
                'range' => 'Kurang RM15000'
            ],
            [
                'id' => 5,
                'range' => 'Lebih RM20000'
            ]
        ]);
    }
}
