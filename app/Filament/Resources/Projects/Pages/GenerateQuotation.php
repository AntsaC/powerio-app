<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Option;
use App\Models\Project;
use App\Services\Quotation\QuotationGeneratorService;
use App\Services\SolarPanel\SolarPanelCalculatorMultiTypeStrategy;
use App\Services\SolarPanel\SolarPanelCalculatorOneTypeStrategy;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class GenerateQuotation extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;

    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.generate-quotation';

    public ?array $data = [];

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
                ComponentsSection::make('Solar Panel Calculation Strategy')
                    ->description('Choose the strategy to calculate the optimal solar panel configuration')
                    ->schema([
                        Radio::make('strategy')
                            ->label('Calculation Strategy')
                            ->options([
                                SolarPanelCalculatorOneTypeStrategy::class => 'Single Panel Type - Uses only one type of solar panel',
                                SolarPanelCalculatorMultiTypeStrategy::class => 'Multiple Panel Types - Combines different panel types for optimal coverage',
                            ])
                            ->descriptions([
                                SolarPanelCalculatorOneTypeStrategy::class => 'Best for uniform installations with consistent panel types',
                                SolarPanelCalculatorMultiTypeStrategy::class => 'Best for maximizing efficiency by combining different panel capacities',
                            ])
                            ->required()
                            ->default(SolarPanelCalculatorOneTypeStrategy::class),
                    ]),

                ComponentsSection::make('Additional Options')
                    ->description('Select optional items to include in the quotation')
                    ->schema([
                        CheckboxList::make('options')
                            ->label('Options')
                            ->options(Option::all()->pluck('name', 'id'))
                            ->descriptions(
                                Option::all()->mapWithKeys(function ($option) {
                                    return [$option->id => '$' . number_format($option->price, 2) . ($option->description ? ' - ' . $option->description : '')];
                                })->toArray()
                            )
                            ->columns(2)
                            ->gridDirection('row'),
                    ]),
            ])
            ->statePath('data');
    }

    public function generate(): void
    {
        $data = $this->form->getState();

        try {
            $quotationService = app(QuotationGeneratorService::class);

            $quotation = $quotationService->generate(
                project: $this->record,
                strategyClass: $data['strategy'],
                optionIds: $data['options'] ?? []
            );

            Notification::make()
                ->success()
                ->title('Quotation generated successfully')
                ->body('Quotation ' . $quotation->quotation_number . ' has been created.')
                ->send();

            $this->redirect(ProjectQuotations::getUrl([$this->record]));

        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Failed to generate quotation')
                ->body($e->getMessage())
                ->send();
        }
    }

    public function cancel(): void
    {
        $this->redirect(ProjectQuotations::getUrl([$this->record]));
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
