<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\Company;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'plan_id' => Plan::factory(),
            'title' => fake()->sentence(),
            'image' => 'ads/sample.jpg',
            'link' => fake()->url(),
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(30),
            'active' => true,
        ];
    }
}
