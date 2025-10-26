<?php

namespace App\DTO;

use App\Models\SolarPanel;

class SolarPanelItemDTO
{
    public function __construct(
        public readonly SolarPanel $solarPanel,
        public readonly int $numberOfPanels
    ) {
    }

    public static function create(
        SolarPanel $solarPanel,
        int $numberOfPanels
    ): self {
        return new self(
            solarPanel: $solarPanel,
            numberOfPanels: $numberOfPanels
        );
    }

    public function toArray(): array
    {
        return [
            'solar_panel' => [
                'id' => $this->solarPanel->id,
                'name' => $this->solarPanel->name,
                'manufacturer' => $this->solarPanel->manufacturer,
                'model' => $this->solarPanel->model,
                'nominal_power' => $this->solarPanel->nominal_power,
                'efficiency' => $this->solarPanel->efficiency,
                'price' => $this->solarPanel->price,
            ],
            'number_of_panels' => $this->numberOfPanels
        ];
    }
}
