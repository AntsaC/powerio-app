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
                                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                    </svg>
                                    <span class="text-xs font-medium text-primary-600 dark:text-primary-400">System Capacity</span>
                                </div>
                                <p class="text-2xl font-bold text-primary-900 dark:text-primary-300">{{ number_format($record->system_capacity, 2) }} <span class="text-sm">kW</span></p>
                            </div>
                        @endif

                        @if($record->installation_type)
                            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-4 rounded-lg border border-green-200 dark:border-green-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
                                    </svg>
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
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
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
