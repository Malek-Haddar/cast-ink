<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex justify-between items-center gap-x-4" style="display: flex; justify-content: space-between;">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                    Welcome back, {{ auth()->user()->name }}!
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Here's what's happening with your podcast platform today.
                </p>
            </div>
            <div>
                <x-filament::button
                    href="/admin/podcasts/create"
                    tag="a"
                    icon="heroicon-m-plus"
                >
                    New Podcast
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
