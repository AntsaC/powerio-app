@props(['project'])

<div class="col-span-2 bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 p-4 rounded-lg border border-amber-200 dark:border-amber-700">
    {{-- Header with Title and Generate Button --}}
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            </svg>
            <span class="text-xs font-medium text-amber-600 dark:text-amber-400">Sunshine Hours</span>
        </div>

        @if($project->location)
            <button
                wire:click="generateSunshineHours"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-white bg-amber-600 hover:bg-amber-700 dark:bg-amber-500 dark:hover:bg-amber-600 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
                {{-- Refresh Icon (shown when not loading) --}}
                <svg wire:loading.remove wire:target="generateSunshineHours" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>

                {{-- Spinner Icon (shown when loading) --}}
                <svg wire:loading wire:target="generateSunshineHours" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <span wire:loading.remove wire:target="generateSunshineHours">Generate</span>
                <span wire:loading wire:target="generateSunshineHours">Generating...</span>
            </button>
        @endif
    </div>

    {{-- Content Area --}}
    @if($project->start_sunshine_hours && $project->end_sunshine_hours)
        {{-- Display Generated Sunshine Hours --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-3 bg-white dark:bg-gray-800 rounded-lg">
                <div class="text-xs text-amber-700 dark:text-amber-300 mb-1">Start Time</div>
                <div class="text-2xl font-bold text-amber-900 dark:text-amber-100">
                    {{ $project->start_sunshine_hours }}<span class="text-sm">h</span>
                </div>
            </div>
            <div class="text-center p-3 bg-white dark:bg-gray-800 rounded-lg">
                <div class="text-xs text-amber-700 dark:text-amber-300 mb-1">End Time</div>
                <div class="text-2xl font-bold text-amber-900 dark:text-amber-100">
                    {{ $project->end_sunshine_hours }}<span class="text-sm">h</span>
                </div>
            </div>
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-4">
            <p class="text-sm text-amber-700 dark:text-amber-300">
                @if($project->location)
                    Click "Generate" to calculate sunshine hours for this location
                @else
                    Add a location to generate sunshine hours
                @endif
            </p>
        </div>
    @endif
</div>
