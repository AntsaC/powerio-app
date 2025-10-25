<?php

namespace App\Filament\Resources\SolarPanels\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SolarPanelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Solar Panel Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('manufacturer')
                            ->maxLength(255),

                        TextInput::make('model')
                            ->maxLength(255),

                        TextInput::make('nominal_power')
                            ->label('Nominal Power (W)')
                            ->required()
                            ->numeric()
                            ->suffix('W')
                            ->minValue(0)
                            ->step(0.01),

                        TextInput::make('efficiency')
                            ->label('Efficiency (%)')
                            ->numeric()
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(0.01),

                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0)
                            ->step(0.01),

                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
