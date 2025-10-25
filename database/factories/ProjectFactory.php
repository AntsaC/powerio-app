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
        // 5 preset locations with valid coordinates
        $locations = [
            [
                'location' => 'Paris, France',
                'latitude' => 48.8566,
                'longitude' => 2.3522,
            ],
            [
                'location' => 'Madrid, Spain',
                'latitude' => 40.4168,
                'longitude' => -3.7038,
            ],
            [
                'location' => 'Berlin, Germany',
                'latitude' => 52.5200,
                'longitude' => 13.4050,
            ],
            [
                'location' => 'Rome, Italy',
                'latitude' => 41.9028,
                'longitude' => 12.4964,
            ],
            [
                'location' => 'Amsterdam, Netherlands',
                'latitude' => 52.3676,
                'longitude' => 4.9041,
            ],
        ];

        $selectedLocation = fake()->randomElement($locations);

        return [
            'name' => fake()->company() . ' Solar Project',
            'description' => fake()->sentence(20),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed', 'on_hold', 'cancelled']),
            'location' => $selectedLocation['location'],
            'latitude' => $selectedLocation['latitude'],
            'longitude' => $selectedLocation['longitude'],
            'system_capacity' => fake()->randomFloat(2, 5, 100),
            'installation_type' => fake()->randomElement(['rooftop', 'ground_mount', 'carport', 'floating', 'other']),
            'start_sunshine_hours' => null,
            'end_sunshine_hours' => null,
        ];
    }
}
