<?php

namespace App\Services\SolarPanel;

use App\Contracts\SolarPanelCalculatorStrategy;
use App\DTO\SolarPanelCalculationDTO;
use App\DTO\SolarPanelItemDTO;
use App\Models\Project;
use App\Repositories\SolarPanelRepository;

class SolarPanelCalculatorOneTypeStrategy extends SolarPanelCalculatorStrategy
{
    public function __construct(
        private SolarPanelRepository $solarPanelRepository
    ) {
    }

    public function generateSolarPanelCalculation(Project $project, float $peakPower): SolarPanelCalculationDTO
    {
        $solarPanels = $this->solarPanelRepository->getAllOrderedByCapacity();

        $suitableSolarPanelItem = null;

        $slightExcessPower = -1;

        foreach ($solarPanels as $panel) {
            
            $numberOfPanels = $this->computeSolarPanelNumber($peakPower, $panel);

            $excessPower = $this->computeExcessPower($numberOfPanels, $panel, $peakPower);

            if ($slightExcessPower -1 || $excessPower < $slightExcessPower) {
                $suitableSolarPanelItem = SolarPanelItemDTO::create(
                    solarPanel: $panel,
                    numberOfPanels: $numberOfPanels
                ); 
            }

        }

        return new SolarPanelCalculationDTO($suitableSolarPanelItem ? [$suitableSolarPanelItem] : []);
    }

}
