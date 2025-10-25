<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuotationLine>
 */
class QuotationLineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $itemTypes = ['product', 'service', 'labor', 'installation', 'warranty', 'other'];
        $itemType = fake()->randomElement($itemTypes);
        $quantity = fake()->numberBetween(1, 50);
        $unitPrice = fake()->randomFloat(2, 50, 1000);
        $discountPercentage = fake()->randomElement([0, 5, 10, 15, 20]);
        $discountAmount = ($quantity * $unitPrice) * ($discountPercentage / 100);
        $lineTotal = ($quantity * $unitPrice) - $discountAmount;

        $descriptions = [
            'product' => fake()->randomElement([
                'High-efficiency solar panel',
                'Solar inverter',
                'Mounting brackets',
                'Solar cables and connectors',
                'Battery storage system',
            ]),
            'service' => fake()->randomElement([
                'System design and engineering',
                'Site assessment',
                'Electrical inspection',
                'System monitoring setup',
            ]),
            'labor' => fake()->randomElement([
                'Solar panel installation',
                'Electrical wiring',
                'System commissioning',
                'Post-installation cleanup',
            ]),
            'installation' => 'Complete solar system installation',
            'warranty' => fake()->randomElement([
                '10-year warranty extension',
                '25-year performance guarantee',
                'Premium maintenance package',
            ]),
            'other' => fake()->sentence(),
        ];

        return [
            'quotation_id' => \App\Models\Quotation::factory(),
            'solar_panel_id' => $itemType === 'product' ? \App\Models\SolarPanel::factory() : null,
            'item_type' => $itemType,
            'description' => $descriptions[$itemType],
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount_percentage' => $discountPercentage,
            'discount_amount' => $discountAmount,
            'line_total' => $lineTotal,
            'sort_order' => fake()->numberBetween(0, 100),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
