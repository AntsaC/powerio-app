<?php

namespace App\Services\Quotation;

use App\Models\Option;
use App\Models\Quotation;
use Illuminate\Support\Collection;

class QuotationOptionService
{
    public function getSelectedOptions(array $optionIds): Collection
    {
        if (empty($optionIds)) {
            return collect([]);
        }

        return Option::whereIn('id', $optionIds)->get();
    }

    public function calculateSubtotal(Collection $selectedOptions): float
    {
        return $selectedOptions->sum('price');
    }

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

    private function formatDescription(Option $option): string
    {
        $description = $option->name;

        if ($option->description) {
            $description .= ' - ' . $option->description;
        }

        return $description;
    }
}
