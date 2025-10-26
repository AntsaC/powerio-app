<?php

namespace App\Services\Quotation;

use App\Contracts\SolarPanelCalculatorStrategy;
use App\DTO\SolarPanelCalculationDTO;
use App\Models\Project;
use App\Models\Quotation;

class QuotationSolarPanelService
{

    public function calculate(Project $project, string $strategyClass): ?SolarPanelCalculationDTO
    {
        $this->validateStrategyClass($strategyClass);

        $strategy = app($strategyClass);
        return $strategy->calculate($project);
    }

    public function calculateSubtotal(SolarPanelCalculationDTO $calculation): float
    {
        return collect($calculation->solarPanels)->sum(function ($item) {
            return $item->totalCost;
        });
    }

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

    private function validateStrategyClass(string $strategyClass): void
    {
        if (!is_subclass_of($strategyClass, SolarPanelCalculatorStrategy::class)) {
            throw new \InvalidArgumentException('Invalid strategy class provided.');
        }
    }

    private function formatDescription($solarPanel): string
    {
        return sprintf(
            '%s (%s W)',
            $solarPanel->name,
            $solarPanel->nominal_power
        );
    }
}
