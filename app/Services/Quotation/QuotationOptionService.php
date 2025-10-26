<?php

namespace App\Services\Quotation;

use App\Models\Option;
use App\Models\Quotation;
use Illuminate\Support\Collection;

class QuotationOptionService
{
    /**
     * Get selected options by IDs
     */
    public function getSelectedOptions(array $optionIds): Collection
    {
        if (empty($optionIds)) {
            return collect([]);
        }

        return Option::whereIn('id', $optionIds)->get();
    }

    /**
     * Calculate subtotal for options
     */
    public function calculateSubtotal(Collection $selectedOptions): float
    {
        return $selectedOptions->sum('price');
    }

    /**
     * Add option lines to the quotation
     */
    public function addLinesToQuotation(Quotation $quotation, Collection $selectedOptions): void
    {
        foreach ($selectedOptions as $option) {
            $quotation->lines()->create([
                'item_type' => 'option',
                'description' => $this->formatDescription($option),
                'quantity' => 1,
                'unit_price' => $option->price,
                'discount_percentage' => 0,
                'discount_amount' => 0,
                'line_total' => $option->price,
            ]);
        }
    }

    /**
     * Format option description for quotation line
     */
    private function formatDescription(Option $option): string
    {
        $description = $option->name;

        if ($option->description) {
            $description .= ' - ' . $option->description;
        }

        return $description;
    }
}
