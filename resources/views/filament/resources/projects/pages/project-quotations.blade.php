<x-filament-panels::page>
    <x-project-detail-layout :project="$this->record">
        <div x-show="activeTab === 'quotations'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
            <div class="space-y-6">
                {{-- Header Section --}}
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Quotations for {{ $record->name }}
                    </h3>
                    <x-filament::button
                        tag="a"
                        href="{{ \App\Filament\Resources\Projects\Pages\GenerateQuotation::getUrl([$record]) }}"
                        color="primary"
                    >
                        Generate New Quotation
                    </x-filament::button>
                </div>

                @php
                    $quotations = $this->getQuotations();
                @endphp

                @if($quotations->isEmpty())
                    {{-- Empty State --}}
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">No quotations</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new quotation for this project.</p>
                    </div>
                @else
                    {{-- Quotations List --}}
                    <div class="space-y-4">
                        @foreach($quotations as $quotation)
                            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                                <div class="p-6">
                                    {{-- Quotation Header --}}
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $quotation->quotation_number }}
                                            </h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                Created on {{ $quotation->quotation_date->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <x-filament::badge :color="match($quotation->status) {
                                            'accepted' => 'success',
                                            'pending' => 'warning',
                                            'rejected' => 'danger',
                                            'draft' => 'gray',
                                            default => 'info'
                                        }">
                                            {{ ucfirst($quotation->status ?? 'draft') }}
                                        </x-filament::badge>
                                    </div>

                                    {{-- Quotation Details Grid --}}
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div>
                                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Valid Until</span>
                                            <p class="text-sm text-gray-900 dark:text-white font-medium mt-1">
                                                {{ $quotation->valid_until ? $quotation->valid_until->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                        <div>
                                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Subtotal</span>
                                            <p class="text-sm text-gray-900 dark:text-white font-medium mt-1">
                                                ${{ number_format($quotation->subtotal, 2) }}
                                            </p>
                                        </div>
                                        <div>
                                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Amount</span>
                                            <p class="text-sm text-primary-600 dark:text-primary-400 font-bold mt-1">
                                                ${{ number_format($quotation->total_amount, 2) }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Quotation Lines Summary --}}
                                    @if($quotation->lines->isNotEmpty())
                                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <h5 class="text-base font-semibold text-gray-900 dark:text-white">Line Items</h5>
                                                <x-filament::badge size="sm">
                                                    {{ $quotation->lines->count() }} {{ Str::plural('item', $quotation->lines->count()) }}
                                                </x-filament::badge>
                                            </div>

                                            <div class="space-y-3">
                                                @foreach($quotation->lines->take(5) as $line)
                                                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors">
                                                        <div class="flex justify-between items-start gap-4">
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-sm font-medium text-gray-900 dark:text-white break-words">
                                                                    {{ $line->description ?? 'Item' }}
                                                                </p>
                                                                <div class="flex items-center gap-4 mt-2">
                                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                                        Qty: <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $line->quantity }}</span>
                                                                    </span>
                                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                                        Unit: <span class="font-semibold text-gray-700 dark:text-gray-300">${{ number_format($line->unit_price, 2) }}</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="text-right flex-shrink-0">
                                                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                                                    ${{ number_format($line->line_total, 2) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @if($quotation->lines->count() > 5)
                                                    <div class="text-center py-3">
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                                                            +{{ $quotation->lines->count() - 5 }} more {{ Str::plural('item', $quotation->lines->count() - 5) }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                            Click "View Details" to see all items
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Notes --}}
                                    @if($quotation->notes)
                                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 block mb-2">Notes</span>
                                            <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 p-3 rounded-lg">
                                                {{ $quotation->notes }}
                                            </p>
                                        </div>
                                    @endif

                                    {{-- Action Buttons --}}
                                    <div class="flex justify-end gap-2 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <x-filament::button
                                            tag="a"
                                            href="#"
                                            color="gray"
                                            size="sm"
                                        >
                                            View Details
                                        </x-filament::button>
                                        <x-filament::button
                                            tag="a"
                                            href="#"
                                            color="primary"
                                            size="sm"
                                        >
                                            Edit
                                        </x-filament::button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </x-project-detail-layout>
</x-filament-panels::page>
