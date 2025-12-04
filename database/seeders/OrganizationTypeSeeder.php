<?php

namespace Database\Seeders;

use App\OrganizationType;
use Illuminate\Database\Seeder;

class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrganizationType::insert([
            ['name' => 'निर्माण सामाग्री'],
            ['name' => 'चुरोट, रक्सी'],
            ['name' => 'भिडियो क्यासेट रेकर्डर तथा प्लेयर उत्पादक ÷वितरक'],
            ['name' => 'सुन, चाँदी बिक्रेताहलुका पेय पदार्थको थोक बिक्रेता'],
            ['name' => 'सुन, चाँदी बिक्रेता'],
        ]);
    }
}
