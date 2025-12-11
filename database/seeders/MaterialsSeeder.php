<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $materials = [
        ['item_name' => 'दमकल', 'quantity' => '१ थान', 'remarks' => 'ड्राईभर-प्रकाश गुरुङ'],
        ['item_name' => 'एम्बुलेन्स', 'quantity' => '३ थान', 'remarks' => null],
        ['item_name' => 'त्रिपाल', 'quantity' => '५० थान', 'remarks' => null],
        ['item_name' => 'मेट्रेस', 'quantity' => '५० थान', 'remarks' => null],
        ['item_name' => 'लाईफ ज्याकेट', 'quantity' => '१५ थान', 'remarks' => null],
        ['item_name' => 'सेफ्टि हेल्मेट', 'quantity' => '१५ थान', 'remarks' => null],
        ['item_name' => 'ट्युव', 'quantity' => '५ थान', 'remarks' => null],
        ['item_name' => 'रेस्क्यु डोरी', 'quantity' => '१२० मिटर', 'remarks' => null],
        ['item_name' => 'फोल्डीङ भर्याङ', 'quantity' => '१ थान', 'remarks' => null],
        ['item_name' => 'मेजरिङ टेप', 'quantity' => '२ थान', 'remarks' => null],
        ['item_name' => 'सेफ्टि ग्लास', 'quantity' => '१५ थान', 'remarks' => null],

        ['item_name' => 'Rरवर सेफ्टी बुट', 'quantity' => '१५ थान', 'remarks' => null],
        ['item_name' => 'स्टेचर', 'quantity' => '१० थान', 'remarks' => null],
        ['item_name' => 'हेण्ड माईक', 'quantity' => '२ थान', 'remarks' => null],
        ['item_name' => 'व्लाङकेट', 'quantity' => '५० थान', 'remarks' => null],
        ['item_name' => 'मेटल वकेट', 'quantity' => '१० थान', 'remarks' => null],
        ['item_name' => 'फायर व्लाङकेट', 'quantity' => '२ थान', 'remarks' => null],
        ['item_name' => 'गल', 'quantity' => '५ थान', 'remarks' => null],
        ['item_name' => 'वेल्चा', 'quantity' => '१० थान', 'remarks' => null],
        ['item_name' => 'गैटी', 'quantity' => '१० थान', 'remarks' => null],
        ['item_name' => 'हाते वन्चरो', 'quantity' => '५ थान', 'remarks' => null],
        ['item_name' => 'हेम्मर', 'quantity' => '५ थान', 'remarks' => null],
        ['item_name' => 'रेन्च', 'quantity' => '२ थान', 'remarks' => null],
        ['item_name' => 'टुल बक्स', 'quantity' => '१ सेट', 'remarks' => null],
        ['item_name' => 'ड्रिल मेसिन', 'quantity' => '१ थान', 'remarks' => null],
        ['item_name' => 'पन्जा', 'quantity' => '२० जोडी', 'remarks' => null],
        ['item_name' => 'प्राथमीक उपचार वक्स','quantity' => '२ सेट', 'remarks' => null],
        ['item_name' => 'थर्मल गन', 'quantity' => '५ सेट', 'remarks' => null],
        ['item_name' => 'टर्च', 'quantity' => '५ सेट', 'remarks' => null],
        ['item_name' => 'दराज', 'quantity' => '१ सेट', 'remarks' => null],
        ['item_name' => 'कार्पेट जुट', 'quantity' => '४० मिटर', 'remarks' => null],
        ['item_name' => 'कम्पयुटर', 'quantity' => '१ सेट', 'remarks' => null],
        ['item_name' => 'प्रिन्टर', 'quantity' => '२ सेट', 'remarks' => null],
        ['item_name' => 'क्यामेरा', 'quantity' => '१ सेट', 'remarks' => null],
        ['item_name' => 'हार्ड ड्राईभ', 'quantity' => '१ सेट', 'remarks' => null],
        ['item_name' => 'इल ई डि सेट', 'quantity' => '१ सेट', 'remarks' => null],
        ['item_name' => 'प्लास्टिक कुर्सी', 'quantity' => '१५ सेट', 'remarks' => null],
        ['item_name' => 'रिभल्विङ कुर्सि', 'quantity' => '१ सेट', 'remarks' => null],
    ];

    DB::table('materials')->insert($materials);
}

}
