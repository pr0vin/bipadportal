<?php

namespace Database\Seeders;

use App\Patient;
use App\Relation;
use App\Municipality;
use App\Organization;
use App\OnlineApplication;
use App\PatientApplication;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(FiscalYearSeeder::class);
        $this->call(ApplicationTypeSeeder::class);
        $this->call(DiseaseSeeder::class);
        if (app()->environment() == 'production') {
        } else {
        }

        $this->call(HospitalSeeder::class);
        $this->call(MonthSeeder::class);
        // $municipality=Municipality::create([
        //     'name'=>'घोडाघोडी नगरपालिका',
        //     'name_en'=>'Ghodaghodi Municipaliity',
        //     'district_id'=>77,
        // ]);
        $org = Organization::create([
            'address_id' => 739,
            'tag_line' => 'नगर कार्यपालिकाको कार्यालय',
            'address_line_one' => 'सुखड',
            'address_line_two' => 'कैलाली',
            'phone' => '091-403064',
            'email' => 'ghodaghodimun@gmail.com',
            'website' => 'ghodaghodimun.gov.np'
        ]);


        // OnlineApplication::factory(2000)->create();

        // $patients = Patient::get();

        // foreach ($patients as $patient) {
        //     PatientApplication::create([
        //         'patient_id' => $patient->id,
        //         'application_type_id' => rand(1, 4),
        //         'registration_date' => now(),
        //     ]);
        // }



        // Setting Seeder

        $this->call(OtherSeeder::class);
        $this->call( MaterialsSeeder::class);


        // $this->call(TruncateSeeder::class);
    }
}
