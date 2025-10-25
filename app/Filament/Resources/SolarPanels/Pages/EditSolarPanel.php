<?php

namespace App\Filament\Resources\SolarPanels\Pages;

use App\Filament\Resources\SolarPanels\SolarPanelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSolarPanel extends EditRecord
{
    protected static string $resource = SolarPanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
