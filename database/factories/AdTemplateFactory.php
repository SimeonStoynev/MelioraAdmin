<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\AdTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AdTemplate>
 */
class AdTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'canva_url' => 'https://canva.com/' . $this->faker->word,
            'status' => $this->faker->randomElement(['draft', 'active', 'archived']),
            'ad_id' => Ad::inRandomOrder()->first(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
