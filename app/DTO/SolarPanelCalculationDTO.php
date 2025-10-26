<?php

namespace App\DTO;

class SolarPanelCalculationDTO
{
    /**
     * @param SolarPanelItemDTO[] $solarPanels
     */
    public function __construct(
        public readonly array $solarPanels
    ) {
    }

    public function toArray(): array
    {
        return [
            'solar_panels' => array_map(
                fn(SolarPanelItemDTO $item) => $item->toArray(),
                $this->solarPanels
            )
        ];
    }

    public function getTotalPanels(): int
    {
        return array_reduce($this->solarPanels, function ($carry, SolarPanelItemDTO $item) {
            return $carry + $item->numberOfPanels;
        }, 0);
    }

    /**
     * Get the option with the least number of panels.
     *
     * @return SolarPanelItemDTO|null
     */
    public function getCheapestByPanelCount(): ?SolarPanelItemDTO
    {
        return !empty($this->solarPanels) ? $this->solarPanels[0] : null;
    }

    /**
     * Get the option with the lowest total cost.
     *
     * @return SolarPanelItemDTO|null
     */
    public function getCheapestByCost(): ?SolarPanelItemDTO
    {
        if (empty($this->solarPanels)) {
            return null;
        }

        return array_reduce($this->solarPanels, function ($carry, SolarPanelItemDTO $item) {
            return $carry === null || $item->totalCost < $carry->totalCost ? $item : $carry;
        });
    }
}
