<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OnlineApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\OnlineApplication::class, 10)->make();
    }
}
