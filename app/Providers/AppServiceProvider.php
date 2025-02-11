<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use App\Http\Responses\LogoutResponse;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * https://filamentphp.com/content/tim-wassenburg-how-to-customize-logout-redirect
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::SIDEBAR_FOOTER ,
            fn (): View =>  view('filament.component.footer'),
        );
        FilamentView::registerRenderHook(
            PanelsRenderHook::TOPBAR_START  ,
            fn (): string =>  USER::where('id', AUTH::id())->pluck('Company')->first() . ' Admin Portal',
        );
    }
}
