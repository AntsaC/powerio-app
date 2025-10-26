<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $options = [
            ['name' => 'Installation Service', 'description' => 'Professional installation by certified technicians'],
            ['name' => 'Extended Warranty (5 years)', 'description' => 'Additional 5-year warranty coverage'],
            ['name' => 'Extended Warranty (10 years)', 'description' => 'Additional 10-year warranty coverage'],
            ['name' => 'Monitoring System', 'description' => 'Real-time solar panel performance monitoring'],
            ['name' => 'Battery Storage System', 'description' => 'Energy storage solution for off-peak usage'],
            ['name' => 'Smart Inverter', 'description' => 'High-efficiency smart inverter with monitoring'],
            ['name' => 'Maintenance Package (Annual)', 'description' => 'Annual maintenance and cleaning service'],
            ['name' => 'Mounting Hardware Upgrade', 'description' => 'Premium mounting system for enhanced durability'],
            ['name' => 'Electrical Panel Upgrade', 'description' => 'Upgrade electrical panel to support solar system'],
            ['name' => 'Energy Management System', 'description' => 'Advanced energy usage optimization system'],
        ];

        $option = fake()->unique()->randomElement($options);

        return [
            'name' => $option['name'],
            'price' => fake()->randomFloat(2, 500, 5000),
            'description' => $option['description'],
        ];
    }
}
