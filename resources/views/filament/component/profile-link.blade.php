<div class="flex flex-row items-center justify-between gap-4">
    {{-- <x-filament::link
    color="gray"
    href="/my-profile"            
    icon="heroicon-o-user"
    icon-alias="panels::widgets.filament-info.open-documentation-button"
    rel="noopener noreferrer"
    target="_self">
        Profile 
    </x-filament::link> --}}
    <ul>
        <li x-data="{ userDropDownIsOpen: false, openWithKeyboard: false }" @keydown.esc.window="userDropDownIsOpen = false, openWithKeyboard = false" class="relative flex items-center">
            <button @click="userDropDownIsOpen = ! userDropDownIsOpen" :aria-expanded="userDropDownIsOpen" @keydown.space.prevent="openWithKeyboard = true" @keydown.enter.prevent="openWithKeyboard = true" @keydown.down.prevent="openWithKeyboard = true" class="rounded-full focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 dark:focus-visible:outline-blue-600" aria-controls="userMenu">
                <img src="https://cdn.mojoimpact.com/sslc/scott-larsen.webp" alt="User Profile" class="h-8 rounded-full object-cover" />
            </button>
            <!-- User Dropdown -->
            <ul x-cloak x-show="userDropDownIsOpen || openWithKeyboard" x-transition.opacity x-trap="openWithKeyboard" style="top:2rem; width:10rem"
               @click.outside="userDropDownIsOpen = false, openWithKeyboard = false" @keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()" 
               id="userMenu" class="absolute flex flex-col overflow-hidden rounded-xl border border-slate-300 bg-slate-100 py-1.5">
                <li class="border-b border-slate-300 dark:border-slate-700">
                    <div class="flex flex-col px-4 py-2">	
                        <span class="text-base font-medium text-black dark:text-white">{{auth()->user()->name}}</span>
                        {{-- <p class="text-sm text-slate-700 dark:text-slate-300">{{session('co.company')}}</p> --}}
                        <p class="text-xs text-slate-700 dark:text-slate-300">{{auth()->user()->email}}</p>
                    </div>
                </li>
                <li><a href="#" class="block bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white">Dashboard</a></li>
                <li><a href="#" class="block bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white">Subscription</a></li>
                {{-- <li>
                    <x-dropdown-link :href="route('profile')" class="w-full hover:bg-stone-200" wire:navigate>
                        {{ __('Profile') }}
                    </x-dropdown-link>                            </li>
                <li>
                    <button wire:click="logout" class="w-full text-start hover:bg-stone-200">
                        <x-dropdown-link>
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </button>
                </li> --}}
            </ul>
        </li>
    </ul>
    <form
        action="{{ filament()->getLogoutUrl() }}"
        method="post"
        class="my-auto">
        @csrf
        <x-filament::button
            color="gray"
            icon="heroicon-m-arrow-left-on-rectangle"
            icon-alias="panels::widgets.account.logout-button"
            labeled-from="sm"
            tag="button"
            type="submit"
        >
            {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
        </x-filament::button>
    </form>
</div>