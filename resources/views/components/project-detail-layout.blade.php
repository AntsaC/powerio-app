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
                                <x-filament::icon
                                    icon="heroicon-o-user"
                                    class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                />
                                <span class="font-medium">{{ $project->customer->name }}</span>
                            </div>
                            @if($project->customer->company)
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                    <x-filament::icon
                                        icon="heroicon-o-building-office"
                                        class="w-4 h-4"
                                    />
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
                            <x-filament::icon
                                icon="heroicon-o-information-circle"
                                class="w-5 h-5"
                            />
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
                            <x-filament::icon
                                icon="heroicon-o-document-text"
                                class="w-5 h-5"
                            />
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