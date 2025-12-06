<?php

namespace Database\Seeders;

use App\CommitteePosition;
use App\Position;
use App\Reason;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reasons = ['मृत्यु भएको', 'सामाजिक सुरक्षा भत्ता पाइरहेको', 'पेन्सन खाइपाइ आएका'];
        foreach ($reasons as $reason) {

            Reason::create([
                'reason' => $reason,
            ]);
        }

        $positions = [
            [
                'name' => 'नगर प्रमुख',
                'position' => '1',
            ],
            [
                'name' => 'उप प्रमुख',
                'position' => '2',
            ],
            [
                'name' => 'अध्यक्ष्',
                'position' => '3',
            ],
            [
                'name' => 'उपध्यक्ष',
                'position' => '4',
            ],
            [
                'name' => 'प्रमुख प्रशासकीय अधिकृत',
                'position' => '5',
            ],
            [
                'name' => 'स्वास्थ्य शाखा प्रमुख',
                'position' => '6',
            ]
        ];

        foreach ($positions as $position) {
            Position::create([
                'name' => $position['name'],
                'position' => $position['position'],
            ]);
        }

        $committeePositions = [
            [
                'name' => 'अध्यक्ष',
                'position' => '1',
            ],
            [
                'name' => 'सदस्य सचिव',
                'position' => '2',
            ],
            [
                'name' => 'सदस्य',
                'position' => '3',
            ],
            [
                'name' => 'संयोजक',
                'position' => '4',
            ],
        ];

        foreach ($committeePositions as $committeePosition) {
            CommitteePosition::create([
                'name' => $committeePosition['name'],
                'position' => $committeePosition['position'],
                'address_id' => 739,
            ]);
        }
        settings()->set([
            'app_name' => 'विपद दर्ता प्रणाली',
            'app_name_en' => 'Patient Registration System',
            'registration_auto_increment_prefix' => '1',
            'registration_number_digits' => '4',
        ]);
    }
}
