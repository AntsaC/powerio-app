<?php

namespace App\Services\Quotation;

use App\DTOs\QuotationTotals;
use App\Models\Project;
use App\Models\Quotation;

class QuotationGeneratorService
{
    private const QUOTATION_VALIDITY_DAYS = 30;

    public function __construct(
        private QuotationSolarPanelService $solarPanelService,
        private QuotationOptionService $optionService,
        private QuotationTotalCalculator $totalCalculator
    ) {
    }


    public function generate(
        Project $project,
        string $strategyClass,
        array $optionIds = []
    ): Quotation {
        $solarPanelCalculation = $this->solarPanelService->calculate($project, $strategyClass);

        if (!$solarPanelCalculation) {
            throw new \Exception('No suitable solar panels found for this project configuration.');
        }

        $selectedOptions = $this->optionService->getSelectedOptions($optionIds);

        $totals = $this->totalCalculator->calculate($solarPanelCalculation, $selectedOptions);

        $quotation = $this->createQuotation($project, $totals);

        $this->solarPanelService->addLinesToQuotation($quotation, $solarPanelCalculation);
        $this->optionService->addLinesToQuotation($quotation, $selectedOptions);

        return $quotation;
    }

    private function createQuotation(
        Project $project,
        QuotationTotals $totals
    ): Quotation {
        return $project->quotations()->create([
            'quotation_number' => $this->generateQuotationNumber(),
            'quotation_date' => now(),
            'valid_until' => now()->addDays(self::QUOTATION_VALIDITY_DAYS),
            'status' => 'draft',
            'subtotal' => $totals->subtotal,
            'tax_rate' => $totals->taxRate,
            'tax_amount' => $totals->taxAmount,
            'total_amount' => $totals->totalAmount,
        ]);
    }

    private function generateQuotationNumber(): string
    {
        return 'QUO-' . strtoupper(uniqid());
    }
}
