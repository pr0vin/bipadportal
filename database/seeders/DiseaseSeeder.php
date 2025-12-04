<?php

namespace Database\Seeders;

use App\Disease;
use App\DiseaseApplication;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diseases')->insert([
            ['name' => 'मृत्यु'],
            ['name' => 'वेपत्ता'],
            ['name' => 'घाईते'],
            ['name' => 'प्रभावित परिवार'],
            ['name' => 'हराएका र जलेका पशुचौपाया'],
            ['name' => 'घरको क्षति (पूर्ण)'],
            ['name' => 'घरको क्षति (आंशिक)'],
            ['name' => 'गोठ क्षति'],
        ]);
    }
    
}
