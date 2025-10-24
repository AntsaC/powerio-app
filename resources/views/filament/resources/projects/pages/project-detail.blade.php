<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $record->name }}
                    </h1>
                    @if($record->description)
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ $record->description }}
                        </p>
                    @endif
                </div>
                <div>
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
            </div>
        </div>

        {{-- Tabs Section --}}
        <div x-data="{ activeTab: 'overview' }" class="space-y-4">
            {{-- Tab Navigation --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-4 p-4 border-b border-gray-200 dark:border-gray-700" aria-label="Tabs">
                    <button
                        @click="activeTab = 'overview'"
                        :class="activeTab === 'overview'
                            ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400'
                            : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'"
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200"
                    >
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            <span>Project Overview</span>
                        </div>
                    </button>
                    <button
                        @click="activeTab = 'technical'"
                        :class="activeTab === 'technical'
                            ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400'
                            : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'"
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200"
                    >
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Technical Details</span>
                        </div>
                    </button>
                </nav>

                {{-- Tab Content --}}
                <div class="p-6">
                    {{-- Overview Tab --}}
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
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Technical Details Tab --}}
                    <div x-show="activeTab === 'technical'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                Technical Specifications
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-2">System Capacity</label>
                                        <div class="flex items-baseline gap-2">
                                            @if($record->system_capacity)
                                                <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($record->system_capacity, 2) }}</span>
                                                <span class="text-lg text-gray-600 dark:text-gray-400">kW</span>
                                            @else
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Not specified</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-2">Installation Type</label>
                                        @if($record->installation_type)
                                            <x-filament::badge color="success" size="lg">
                                                {{ str_replace('_', ' ', ucfirst($record->installation_type)) }}
                                            </x-filament::badge>
                                        @else
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Not specified</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 p-6 rounded-lg border border-amber-200 dark:border-amber-700">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400 mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                        </svg>
                                        <div>
                                            <h4 class="font-semibold text-amber-900 dark:text-amber-300 mb-2">Solar Panel System</h4>
                                            <p class="text-sm text-amber-800 dark:text-amber-400">
                                                This project involves the installation and management of solar panel systems for renewable energy generation.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
