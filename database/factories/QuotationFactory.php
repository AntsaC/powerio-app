<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quotation>
 */
class QuotationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quotationDate = fake()->dateTimeBetween('-6 months', 'now');
        $validUntil = fake()->dateTimeBetween($quotationDate, '+30 days');
        $subtotal = fake()->randomFloat(2, 5000, 50000);
        $taxRate = fake()->randomElement([0, 5.5, 10, 20]); // Common tax rates
        $taxAmount = $subtotal * ($taxRate / 100);
        $discountAmount = fake()->randomFloat(2, 0, $subtotal * 0.1); // Up to 10% discount
        $totalAmount = $subtotal + $taxAmount - $discountAmount;

        return [
            'project_id' => \App\Models\Project::factory(),
            'quotation_number' => 'QT-' . fake()->year() . '-' . fake()->unique()->numberBetween(1000, 9999),
            'quotation_date' => $quotationDate,
            'valid_until' => $validUntil,
            'status' => fake()->randomElement(['draft', 'sent', 'accepted', 'rejected', 'expired']),
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
