@props(['project' => null])

<div class="space-y-6">
        {{-- Header Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $project->name }}
                    </h1>
                    @if($project->description)
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ $project->description }}
                        </p>
                    @endif
                    @if($project->customer)
                        <div class="mt-3 flex items-center gap-4 text-sm">
                            <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <span class="font-medium">{{ $project->customer->name }}</span>
                            </div>
                            @if($project->customer->company)
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                    </svg>
                                    <span>{{ $project->customer->company }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div>
                    <x-filament::badge :color="match($project->status) {
                        'completed' => 'success',
                        'in_progress' => 'info',
                        'on_hold' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray'
                    }">
                        {{ str_replace('_', ' ', ucfirst($project->status)) }}
                    </x-filament::badge>
                </div>
            </div>
        </div>

        {{-- Tabs Section --}}
        <div x-data="{ activeTab: '{{ request()->routeIs('filament.admin.resources.projects.quotations') ? 'quotations' : 'overview' }}' }" class="space-y-4">
            {{-- Tab Navigation --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-4 p-4 border-b border-gray-200 dark:border-gray-700" aria-label="Tabs">
                    <a
                        href="{{ \App\Filament\Resources\Projects\Pages\ProjectDetail::getUrl([$project]) }}"
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
                    </a>

                    <a
                        href="{{ \App\Filament\Resources\Projects\Pages\ProjectQuotations::getUrl([$project]) }}"
                        @click="activeTab = 'quotations'"
                        :class="activeTab === 'quotations'
                            ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400'
                            : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'"
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200"
                    >
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <span>Quotations</span>
                        </div>
                    </a>
                </nav>

                {{-- Tab Content --}}
                <div class="p-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>