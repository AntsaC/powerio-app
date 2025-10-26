<?php

namespace App\Services\Quotation;

use App\Contracts\SolarPanelCalculatorStrategy;
use App\DTO\SolarPanelCalculationDTO;
use App\Models\Project;
use App\Models\Quotation;

class QuotationSolarPanelService
{
    /**
     * Calculate solar panels using the specified strategy
     */
    public function calculate(Project $project, string $strategyClass): ?SolarPanelCalculationDTO
    {
        $this->validateStrategyClass($strategyClass);

        $strategy = app($strategyClass);
        return $strategy->calculate($project);
    }

    /**
     * Calculate subtotal for solar panels
     */
    public function calculateSubtotal(SolarPanelCalculationDTO $calculation): float
    {
        return collect($calculation->solarPanels)->sum(function ($item) {
            return $item->totalCost;
        });
    }

    /**
     * Add solar panel lines to the quotation
     */
    public function addLinesToQuotation(
        Quotation $quotation,
        SolarPanelCalculationDTO $calculation
    ): void {
        foreach ($calculation->solarPanels as $item) {
            $quotation->lines()->create([
                'solar_panel_id' => $item->solarPanel->id,
                'item_type' => 'solar_panel',
                'description' => $this->formatDescription($item->solarPanel),
                'quantity' => $item->numberOfPanels,
                'unit_price' => $item->solarPanel->price,
                'discount_percentage' => 0,
                'discount_amount' => 0,
                'line_total' => $item->totalCost,
            ]);
        }
    }

    /**
     * Validate that the provided class is a valid strategy
     */
    private function validateStrategyClass(string $strategyClass): void
    {
        if (!is_subclass_of($strategyClass, SolarPanelCalculatorStrategy::class)) {
            throw new \InvalidArgumentException('Invalid strategy class provided.');
        }
    }

    /**
     * Format solar panel description for quotation line
     */
    private function formatDescription($solarPanel): string
    {
        return sprintf(
            '%s (%s - %s)',
            $solarPanel->name,
            $solarPanel->manufacturer,
            $solarPanel->model
        );
    }
}
