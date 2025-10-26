<?php

namespace App\Contracts;

use App\DTO\SolarPanelCalculationDTO;
use App\Models\Project;
use App\Models\SolarPanel;

abstract class SolarPanelCalculatorStrategy
{
    public const LOSS_FACTOR = 0.8;

    public const POWER_MARGIN = 100;

    public function calculate(Project $project): SolarPanelCalculationDTO {
        if (empty($project->system_capacity)) {
            throw new \InvalidArgumentException('Project must have a system capacity to calculate solar panels');
        }
        $peakPower = $this->computePeakPower($project);
        return $this->generateSolarPanelCalculation($project, $peakPower);
    }

    public function computePeakPower(Project $project) : float {
        return $project->convertSystemCapacityInWhat() / ($project->getSunshineDailyHour() * self::LOSS_FACTOR);
    }

    protected abstract function generateSolarPanelCalculation(Project $project, float $peakPower): ?SolarPanelCalculationDTO;

    protected function isOverPower(SolarPanel $solarPanel, float $power) : bool {
        return $solarPanel->nominal_power - $power > self::POWER_MARGIN;
    }

    protected function computeExcessPower(int $panelNumber, SolarPanel $solarPanel, float $peakPower) : float {
        return ($solarPanel->nominal_power * $panelNumber) - $peakPower;
    }

    protected function computeSolarPanelNumber(float $peakPower, SolarPanel $solarPanel) : int {
        return ceil( $peakPower /  $solarPanel->nominal_power);
    }

}
