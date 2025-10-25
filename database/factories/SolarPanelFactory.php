<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SolarPanel>
 */
class SolarPanelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $manufacturers = ['Sunpower', 'LG', 'Panasonic', 'Canadian Solar', 'JinkoSolar', 'Trina Solar', 'Q Cells'];
        $manufacturer = fake()->randomElement($manufacturers);

        return [
            'name' => $manufacturer . ' Solar Panel ' . fake()->bothify('??-###'),
            'manufacturer' => $manufacturer,
            'model' => fake()->bothify('SP-####??'),
            'nominal_power' => fake()->randomFloat(2, 250, 500), // 250W to 500W
            'efficiency' => fake()->randomFloat(2, 15, 23), // 15% to 23%
            'price' => fake()->randomFloat(2, 150, 600), // $150 to $600
            'description' => fake()->optional()->sentence(10),
        ];
    }
}
