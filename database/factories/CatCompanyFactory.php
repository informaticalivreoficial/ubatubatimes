<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatCompany>
 */
class CatCompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->words(2, true);

        return [
            'id_pai' => null, // será preenchido no seeder
            'title' => ucfirst($title),
            'content' => $this->faker->optional()->paragraph(),
            'slug' => Str::slug($title),
            'tags' => implode(',', $this->faker->words(4)),
            'views' => $this->faker->numberBetween(0, 1000),
            'type' => 'company',
            'status' => $this->faker->boolean(),
        ];
    }
}
