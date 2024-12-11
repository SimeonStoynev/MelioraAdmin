<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\AdTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ad>
 */
class AdFactory extends Factory
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
            'url' => $this->faker->url,
            'status' => $this->faker->randomElement(['pending', 'in-progress', 'completed']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure(): Factory|AdFactory
    {
        return $this->afterCreating(function (Ad $ad) {
            if ($this->faker->boolean()) {
                AdTemplate::factory()->create([
                    'ad_id' => $ad->id,
                ]);
            }
        });
    }
}
