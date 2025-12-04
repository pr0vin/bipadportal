<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FiscalYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::unprepared(
            file_get_contents(__DIR__ . '/fiscal_years.sql')
        );
    }
}
