<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class DirghaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'disease_id' => rand(1, 36),
            'name' => $this->faker->name,
            'name_en' => $this->faker->name,
            'citizenship_number' => rand(000000, 999999),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'age' => rand(50, 80),
            'province_id' => 7,
            'district_id' => 77,
            'municipality_id' => 1,
            'ward_number' => rand(1, 9),
            'tole' => $this->faker->name,
            'contact_person' => $this->faker->name,
            'mobile_number' => Str::random(10),
            'email' => $this->faker->unique()->safeEmail,
            'description' => $this->faker->name,
            'fiscal_year_id' => 10,
        ];
    }
}
