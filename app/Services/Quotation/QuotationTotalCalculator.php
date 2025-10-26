<?php

namespace App\Services\Quotation;

use App\DTOs\QuotationTotals;
use Illuminate\Support\Collection;

class QuotationTotalCalculator
{
    private const DEFAULT_TAX_RATE = 10.0;

    public function __construct(
        private QuotationSolarPanelService $solarPanelService,
        private QuotationOptionService $optionService
    ) {}

    public function calculate($calculation, Collection $selectedOptions, ?float $taxRate = null): QuotationTotals
    {
        $taxRate = $taxRate ?? self::DEFAULT_TAX_RATE;

        $solarPanelSubtotal = $this->solarPanelService->calculateSubtotal($calculation);
        $optionsSubtotal = $this->optionService->calculateSubtotal($selectedOptions);

        $subtotal = $solarPanelSubtotal + $optionsSubtotal;
        $taxAmount = $this->calculateTax($subtotal, $taxRate);
        $totalAmount = $subtotal + $taxAmount;

        return QuotationTotals::create(
            subtotal: $subtotal,
            taxRate: $taxRate,
            taxAmount: $taxAmount,
            totalAmount: $totalAmount
        );
    }

    private function calculateTax(float $taxableAmount, float $taxRate): float
    {
        return $taxableAmount * ($taxRate / 100);
    }
}
