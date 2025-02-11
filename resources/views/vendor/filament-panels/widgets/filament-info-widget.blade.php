<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex-1">              
                <h2 class="text-2xl">Two Shakes Review</h2>
                <h3 class="text-sm text-zinc-400">Another Mojo Impact Web App</h3>                
            </div>
            <div class="flex flex-col items-end gap-y-1">
                <x-filament::link
                    color="gray"
                    href="https://support.mojoimpact.com/"
                    icon="heroicon-o-lifebuoy"
                    icon-alias="panels::widgets.filament-info.open-documentation-button"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                   Support 
                </x-filament::link>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>