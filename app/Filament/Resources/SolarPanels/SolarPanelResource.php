<?php

namespace App\Filament\Resources\SolarPanels;

use App\Filament\Resources\SolarPanels\Pages\CreateSolarPanel;
use App\Filament\Resources\SolarPanels\Pages\EditSolarPanel;
use App\Filament\Resources\SolarPanels\Pages\ListSolarPanels;
use App\Filament\Resources\SolarPanels\Schemas\SolarPanelForm;
use App\Filament\Resources\SolarPanels\Tables\SolarPanelsTable;
use App\Models\SolarPanel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SolarPanelResource extends Resource
{
    protected static ?string $model = SolarPanel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SolarPanelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SolarPanelsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSolarPanels::route('/'),
            'create' => CreateSolarPanel::route('/create'),
            'edit' => EditSolarPanel::route('/{record}/edit'),
        ];
    }
}
