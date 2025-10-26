<?php

namespace App\Services\SolarPanel;

use App\Contracts\SolarPanelCalculatorStrategy;
use App\DTO\SolarPanelCalculationDTO;
use App\DTO\SolarPanelItemDTO;
use App\Models\Project;
use App\Repositories\SolarPanelRepository;

class SolarPanelCalculatorMultiTypeStrategy extends SolarPanelCalculatorStrategy
{
    public function __construct(
        private SolarPanelRepository $solarPanelRepository
    ) {
    }

    public function generateSolarPanelCalculation(Project $project, float $peakPower): SolarPanelCalculationDTO
    {
        $solarPanels = $this->solarPanelRepository->getAllOrderedByNominalPower();

        $calculations = [];
        $remainingPower = $peakPower;

        foreach ($solarPanels as $panel) {
            $numberOfPanels = floor($remainingPower / $panel->nominal_power);

            if ($numberOfPanels > 0) {
                $calculations[] = SolarPanelItemDTO::create(
                    solarPanel: $panel,
                    numberOfPanels: (int) $numberOfPanels
                );

                $remainingPower -= ($numberOfPanels * $panel->nominal_power);
            }

            if ($remainingPower <= 0) {
                break;
            }
        }

        // If we still have remaining power, add one more panel of the smallest suitable type
        if ($remainingPower > 0 && !empty($calculations)) {
            $lastPanel = end($calculations);
            $calculations[] = SolarPanelItemDTO::create(
                solarPanel: $lastPanel->solarPanel,
                numberOfPanels: 1
            );
        } 

        return new SolarPanelCalculationDTO($calculations);
    }
}
