<?php

namespace Database\Seeders;

use App\Month;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Month::create([
            'month'=>'1'
        ]);
        Month::create([
            'month'=>'4'
        ]);
        Month::create([
            'month'=>'7'
        ]);
        Month::create([
            'month'=>'10'
        ]);
    }
}
