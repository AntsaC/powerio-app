<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Customer Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('company')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Address Information')
                    ->schema([
                        Textarea::make('address')
                            ->rows(3)
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        TextInput::make('city')
                            ->maxLength(255),
                        TextInput::make('state')
                            ->maxLength(255),
                        TextInput::make('postal_code')
                            ->maxLength(255),
                        TextInput::make('country')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Additional Notes')
                    ->schema([
                        Textarea::make('notes')
                            ->rows(4)
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
