@php
    use App\Models\Subscription;
    $user = filament()->auth()->user();
    $accStatus = Subscription::where('user_id', $user->id)->pluck('stripe_status');   
    $accStatus->isEmpty() ? $accStatus[0] = 'Super Admin' : $accStatus[0];
    $color = match ($accStatus[0]) {
        'Super Admin' => 'goldenrod',
        'active' => '#14A44D',
        'trialing' => '#285192',
        'past_due' => '#B0233A',
        'incomplete' => '#B0233A',
        'incomplete_expired' => '#B0233A',
        'cancelled' => '#ff9933',
        'unpaid' => '#8C030E',
        'paused' => 'yellow',    
    };
    // //$subscription = Subscription::where('user_id', $user->id)->first();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <x-filament-panels::avatar.user size="lg" :user="$user" />

            <div class="flex-1">
                {{-- <h2
                    class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
                    {{ __('filament-panels::widgets/account-widget.welcome', ['app' => config('app.name')]) }}
                </h2> --}}

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ filament()->getUserName($user) }}
                </p>
                <p>
                    <span style="float:right; text-transform: capitalize; color:{{ $color }}">{{ $accStatus[0] }}</span>
                </p>
            </div>

            <form
                action="{{ filament()->getLogoutUrl() }}"
                method="post"
                class="my-auto"
            >
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
    </x-filament::section>
</x-filament-widgets::widget>
