@props(['project' => null])

<div class="space-y-6">
        {{-- Header Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $project->name }}
                    </h1>
                    @if($project->description)
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ $project->description }}
                        </p>
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
        <div x-data="{ activeTab: 'overview' }" class="space-y-4">
            {{-- Tab Navigation --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-4 p-4 border-b border-gray-200 dark:border-gray-700" aria-label="Tabs">
                    <a
                        href="{{ \App\Filament\Resources\Projects\Pages\ProjectDetail::getUrl([$project]) }}"
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
                </nav>

                {{-- Tab Content --}}
                <div class="p-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>