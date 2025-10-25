<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Solar Project',
            'description' => fake()->sentence(20),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed', 'on_hold', 'cancelled']),
            'location' => fake()->city() . ', ' . fake()->country(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'system_capacity' => fake()->randomFloat(2, 5, 100),
            'installation_type' => fake()->randomElement(['rooftop', 'ground_mount', 'carport', 'floating', 'other']),
            'start_sunshine_hours' => null,
            'end_sunshine_hours' => null,
        ];
    }
}
