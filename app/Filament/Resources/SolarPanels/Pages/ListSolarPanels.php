<?php

namespace App\Filament\Resources\SolarPanels\Pages;

use App\Filament\Resources\SolarPanels\SolarPanelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSolarPanels extends ListRecords
{
    protected static string $resource = SolarPanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
