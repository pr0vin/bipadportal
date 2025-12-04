<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert([
            // Province 1
            ['province_id' => 1, 'name' => 'Ilam', 'name_en' => 'Ilam'],
            ['province_id' => 1, 'name' => 'Jhapa', 'name_en' => 'Jhapa'],
            ['province_id' => 1, 'name' => 'Panchthar', 'name_en' => 'Panchthar'],
            ['province_id' => 1, 'name' => 'Taplejung', 'name_en' => 'Taplejung'],
            ['province_id' => 1, 'name' => 'Tehrathum', 'name_en' => 'Tehrathum'],
            ['province_id' => 1, 'name' => 'Khotang', 'name_en' => 'Khotang'],
            ['province_id' => 1, 'name' => 'Sankhuwasabha', 'name_en' => 'Sankhuwasabha'],
            ['province_id' => 1, 'name' => 'Solukhumbu', 'name_en' => 'Solukhumbu'],
            ['province_id' => 1, 'name' => 'Okhaldhunga', 'name_en' => 'Okhaldhunga'],
            ['province_id' => 1, 'name' => 'Bhojpur', 'name_en' => 'Bhojpur'],

            // Province 2
            ['province_id' => 2, 'name' => 'Saptari', 'name_en' => 'Saptari'],
            ['province_id' => 2, 'name' => 'Siraha', 'name_en' => 'Siraha'],
            ['province_id' => 2, 'name' => 'Dhanusha', 'name_en' => 'Dhanusha'],
            ['province_id' => 2, 'name' => 'Mahottari', 'name_en' => 'Mahottari'],
            ['province_id' => 2, 'name' => 'Sarlahi', 'name_en' => 'Sarlahi'],
            ['province_id' => 2, 'name' => 'Rautahat', 'name_en' => 'Rautahat'],
            ['province_id' => 2, 'name' => 'Bara', 'name_en' => 'Bara'],
            ['province_id' => 2, 'name' => 'Parsa', 'name_en' => 'Parsa'],
            ['province_id' => 2, 'name' => 'Janjgir', 'name_en' => 'Janjgir'],

            // Province 3
            ['province_id' => 3, 'name' => 'Kathmandu', 'name_en' => 'Kathmandu'],
            ['province_id' => 3, 'name' => 'Bhaktapur', 'name_en' => 'Bhaktapur'],
            ['province_id' => 3, 'name' => 'Lalitpur', 'name_en' => 'Lalitpur'],
            ['province_id' => 3, 'name' => 'Dolakha', 'name_en' => 'Dolakha'],
            ['province_id' => 3, 'name' => 'Sindhupalchok', 'name_en' => 'Sindhupalchok'],
            ['province_id' => 3, 'name' => 'Ramechhap', 'name_en' => 'Ramechhap'],
            ['province_id' => 3, 'name' => 'Kavrepalanchok', 'name_en' => 'Kavrepalanchok'],
            ['province_id' => 3, 'name' => 'Sindhuli', 'name_en' => 'Sindhuli'],
            ['province_id' => 3, 'name' => 'Makwanpur', 'name_en' => 'Makwanpur'],
            ['province_id' => 3, 'name' => 'Nuwakot', 'name_en' => 'Nuwakot'],

            // Province 4
            ['province_id' => 4, 'name' => 'Kaski', 'name_en' => 'Kaski'],
            ['province_id' => 4, 'name' => 'Manang', 'name_en' => 'Manang'],
            ['province_id' => 4, 'name' => 'Mustang', 'name_en' => 'Mustang'],
            ['province_id' => 4, 'name' => 'Syangja', 'name_en' => 'Syangja'],
            ['province_id' => 4, 'name' => 'Parbat', 'name_en' => 'Parbat'],
            ['province_id' => 4, 'name' => 'Baglung', 'name_en' => 'Baglung'],
            ['province_id' => 4, 'name' => 'Gorkha', 'name_en' => 'Gorkha'],
            ['province_id' => 4, 'name' => 'Lamjung', 'name_en' => 'Lamjung'],

            // Province 5
            ['province_id' => 5, 'name' => 'Rupandehi', 'name_en' => 'Rupandehi'],
            ['province_id' => 5, 'name' => 'Nawalparasi', 'name_en' => 'Nawalparasi'],
            ['province_id' => 5, 'name' => 'Kapilvastu', 'name_en' => 'Kapilvastu'],
            ['province_id' => 5, 'name' => 'Syangja', 'name_en' => 'Syangja'],
            ['province_id' => 5, 'name' => 'Palpa', 'name_en' => 'Palpa'],
            ['province_id' => 5, 'name' => 'Arghakhanchi', 'name_en' => 'Arghakhanchi'],
            ['province_id' => 5, 'name' => 'Gulmi', 'name_en' => 'Gulmi'],
            ['province_id' => 5, 'name' => 'Ramechhap', 'name_en' => 'Ramechhap'],

            // Province 6
            ['province_id' => 6, 'name' => 'Bajura', 'name_en' => 'Bajura'],
            ['province_id' => 6, 'name' => 'Bajhang', 'name_en' => 'Bajhang'],
            ['province_id' => 6, 'name' => 'Achham', 'name_en' => 'Achham'],
            ['province_id' => 6, 'name' => 'Doti', 'name_en' => 'Doti'],
            ['province_id' => 6, 'name' => 'Kailali', 'name_en' => 'Kailali'],
            ['province_id' => 6, 'name' => 'Kanchanpur', 'name_en' => 'Kanchanpur'],

            // Province 7
            ['province_id' => 7, 'name' => 'Dadeldhura', 'name_en' => 'Dadeldhura'],
            ['province_id' => 7, 'name' => 'Darchula', 'name_en' => 'Darchula'],
            ['province_id' => 7, 'name' => 'Baitadi', 'name_en' => 'Baitadi'],
            ['province_id' => 7, 'name' => 'Bhaktapur', 'name_en' => 'Bhaktapur'],
            ['province_id' => 7, 'name' => 'Kanchanpur', 'name_en' => 'Kanchanpur'],
        ]);
    }
}
