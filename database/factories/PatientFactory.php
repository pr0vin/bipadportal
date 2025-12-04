<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $todayDate=$this->faker->dateTimeBetween('-1 months', 'now');
        return [
            'applied_date'=>$todayDate,
            'disease_id' => rand(1, 36),
            'name' => $this->faker->name,
            'name_en' => $this->faker->name,
            'citizenship_number' => rand(000000, 999999),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'age' => rand(50, 80),
            // 'province_id' => 7,
            // 'district_id' => 77,
            // 'address_id' => rand(731,752),
            'address_id' => 739,
            'ward_number' => rand(1, 10),
            'tole' => $this->faker->name,
            'contact_person' => $this->faker->name,
            'mobile_number' => rand(9711111111,9899999999),
            'email' => $this->faker->unique()->safeEmail,
            'description' => $this->faker->name,
            'fiscal_year_id' => rand(1,2),
        ];
    }
}
