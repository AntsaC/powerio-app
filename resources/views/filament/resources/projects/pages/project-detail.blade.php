<x-filament-panels::page>
    <x-project-detail-layout :project="$this->record">
        <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Project Information Card --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                        Project Information
                    </h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-start">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Project Name</span>
                            <span class="text-sm text-gray-900 dark:text-white font-medium text-right">{{ $record->name }}</span>
                        </div>

                        <div class="flex justify-between items-start">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</span>
                            <x-filament::badge :color="match($record->status) {
                                'completed' => 'success',
                                'in_progress' => 'info',
                                'on_hold' => 'warning',
                                'cancelled' => 'danger',
                                default => 'gray'
                            }">
                                {{ str_replace('_', ' ', ucfirst($record->status)) }}
                            </x-filament::badge>
                        </div>

                        @if($record->description)
                            <div class="pt-2">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-2">Description</span>
                                <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 p-3 rounded-lg">
                                    {{ $record->description }}
                                </p>
                            </div>
                        @endif

                        <div class="flex justify-between items-start pt-2">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ $record->created_at->format('M d, Y') }}</span>
                        </div>

                        <div class="flex justify-between items-start">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ $record->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Quick Stats Card --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                        Quick Stats
                    </h3>

                    <div class="grid grid-cols-2 gap-4">
                        @if($record->system_capacity)
                            <div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 p-4 rounded-lg border border-primary-200 dark:border-primary-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <x-filament::icon
                                        icon="heroicon-o-bolt"
                                        class="w-5 h-5 text-primary-600 dark:text-primary-400"
                                    />
                                    <span class="text-xs font-medium text-primary-600 dark:text-primary-400">System Capacity</span>
                                </div>
                                <p class="text-2xl font-bold text-primary-900 dark:text-primary-300">{{ number_format($record->system_capacity, 2) }} <span class="text-sm">kW</span></p>
                            </div>
                        @endif

                        @if($record->installation_type)
                            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-4 rounded-lg border border-green-200 dark:border-green-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <x-filament::icon
                                        icon="heroicon-o-building-office-2"
                                        class="w-5 h-5 text-green-600 dark:text-green-400"
                                    />
                                    <span class="text-xs font-medium text-green-600 dark:text-green-400">Installation Type</span>
                                </div>
                                <p class="text-sm font-bold text-green-900 dark:text-green-300">{{ str_replace('_', ' ', ucfirst($record->installation_type)) }}</p>
                            </div>
                        @endif

                        {{-- Sunshine Hours Card --}}
                        <x-sunshine-hours-card :project="$record" />

                        @if($record->location)
                            <div class="col-span-2 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-4 rounded-lg border border-blue-200 dark:border-blue-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <x-filament::icon
                                        icon="heroicon-o-map-pin"
                                        class="w-5 h-5 text-blue-600 dark:text-blue-400"
                                    />
                                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400">Location</span>
                                </div>
                                <p class="text-sm font-medium text-blue-900 dark:text-blue-300">{{ $record->location }}</p>
                                @if($record->latitude && $record->longitude)
                                    <div class="mt-2 pt-2 border-t border-blue-200 dark:border-blue-700">
                                        <div class="flex items-center gap-4 text-xs">
                                            <span class="text-blue-700 dark:text-blue-300">
                                                <span class="font-medium">Latitude:</span> {{ number_format($record->latitude, 6) }}
                                            </span>
                                            <span class="text-blue-700 dark:text-blue-300">
                                                <span class="font-medium">Longitude:</span> {{ number_format($record->longitude, 6) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </x-project-detail-layout>

</x-filament-panels::page>
