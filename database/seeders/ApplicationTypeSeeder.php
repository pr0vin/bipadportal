<?php

namespace Database\Seeders;

use App\ApplicationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApplicationType::create([
            'name'=>'आगलागी',
            'amount'=>'100000'
        ]);
        ApplicationType::create([
            'name'=>'वाढी डुबान',
            'amount'=>'100000'
        ]);
        ApplicationType::create([
            'name'=>'चत्याङ',
            'amount'=>'100000'
        ]);
        ApplicationType::create([
            'name'=>'भुईचालो',
            'amount'=>'100000'
        ]);

          ApplicationType::create([
            'name'=>'सितलहर',
            'amount'=>'100000'
        ]);

          ApplicationType::create([
            'name'=>'हावाहुरी',
            'amount'=>'100000'
        ]);

         ApplicationType::create([
            'name'=>'दुर्घटना',
            'amount'=>'100000'
        ]);

         ApplicationType::create([
            'name'=>'धानबाली दुवेको',
            'amount'=>'100000'
        ]);
    }
}
