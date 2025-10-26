<?php

namespace App\Services\Quotation;

use App\Models\Project;
use App\Models\Quotation;

class QuotationGeneratorService
{
    private const TAX_RATE = 10.0; // 10% tax
    private const QUOTATION_VALIDITY_DAYS = 30;

    public function __construct(
        private QuotationSolarPanelService $solarPanelService,
        private QuotationOptionService $optionService
    ) {
    }

    /**
     * Generate a quotation for a project using the specified strategy and options
     */
    public function generate(
        Project $project,
        string $strategyClass,
        array $optionIds = []
    ): Quotation {
        // Calculate solar panels using the selected strategy
        $calculation = $this->solarPanelService->calculate($project, $strategyClass);

        if (!$calculation) {
            throw new \Exception('No suitable solar panels found for this project configuration.');
        }

        // Get selected options
        $selectedOptions = $this->optionService->getSelectedOptions($optionIds);

        // Calculate totals
        $totals = $this->calculateTotals($calculation, $selectedOptions);

        // Create quotation
        $quotation = $this->createQuotation($project, $strategyClass, $totals);

        // Add quotation lines
        $this->solarPanelService->addLinesToQuotation($quotation, $calculation);
        $this->optionService->addLinesToQuotation($quotation, $selectedOptions);

        return $quotation;
    }

    /**
     * Calculate totals for the quotation
     */
    private function calculateTotals($calculation, $selectedOptions): array
    {
        $solarPanelSubtotal = $this->solarPanelService->calculateSubtotal($calculation);
        $optionsSubtotal = $this->optionService->calculateSubtotal($selectedOptions);
        $subtotal = $solarPanelSubtotal + $optionsSubtotal;
        $taxAmount = $this->calculateTax($subtotal);
        $totalAmount = $subtotal + $taxAmount;

        return [
            'subtotal' => $subtotal,
            'tax_rate' => self::TAX_RATE,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
        ];
    }

    /**
     * Calculate tax amount
     */
    private function calculateTax(float $subtotal): float
    {
        return $subtotal * (self::TAX_RATE / 100);
    }

    /**
     * Create the quotation record
     */
    private function createQuotation(
        Project $project,
        string $strategyClass,
        array $totals
    ): Quotation {
        return $project->quotations()->create([
            'quotation_number' => $this->generateQuotationNumber(),
            'quotation_date' => now(),
            'valid_until' => now()->addDays(self::QUOTATION_VALIDITY_DAYS),
            'status' => 'draft',
            'subtotal' => $totals['subtotal'],
            'tax_rate' => $totals['tax_rate'],
            'tax_amount' => $totals['tax_amount'],
            'discount_amount' => 0,
            'total_amount' => $totals['total_amount'],
            'notes' => 'Strategy used: ' . class_basename($strategyClass),
        ]);
    }

    /**
     * Generate a unique quotation number
     */
    private function generateQuotationNumber(): string
    {
        return 'QUO-' . strtoupper(uniqid());
    }
}
