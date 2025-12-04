<?php

namespace Database\Factories;

use App\Patient;
use Illuminate\Support\Str;
use App\Services\OnlineApplicationService;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnlineApplicationFactory extends Factory
{
    public function definition()
    {
        $dirghaFactory = new DirghaFactory(); // Create an instance of the UserFactory

        $onlineApplicationService = new OnlineApplicationService();
        $client = Patient::factory()->create();
        $tokenNumber = $onlineApplicationService->generateToken($client->id);

        return [
            'token_number' => $tokenNumber,
            'patient_id' => $client->id,
            'applicant_ip' => "127.0.0.1"
        ];
    }
}
