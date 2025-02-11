<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\Alignment;
use Filament\Navigation\NavigationItem;
use App\Http\Middleware\ActiveSubscriber;
use Filament\Http\Middleware\Authenticate;
use Filament\Support\Enums\VerticalAlignment;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Notifications\Livewire\Notifications;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class AdminPanelProvider extends PanelProvider{ 
    public function mount(){
        ray('AdminPanelProvider mounted');
    }
    public function panel(Panel $panel): Panel
    {  
        
        Notifications::alignment(Alignment::Center);
        Notifications::verticalAlignment(VerticalAlignment::Center);      
        return $panel
        // ->assets([
        //     Css::make('custom-stylesheet', resource_path('css/app/custom.css')), 
        // ])
            ->spa()   
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth(MaxWidth::FitContent)
            ->font('Josefin Sans')
            ->brandLogo(fn () => view('filament.component.brand'))
            ->darkMode(false)
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Yellow,
                'violet' => Color::Violet,
                'teal'  => Color::Teal,
            ])
            ->favicon(asset('images/favicon.svg'))
            ->navigationItems([
                NavigationItem::make('Logout')
                    ->url('/getLO', shouldOpenInNewTab: false)
                    ->icon('heroicon-o-arrow-left-start-on-rectangle')
                    ->sort(10)
                    ->group('Logout')
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => auth()->user()->name . '\'s Profile')
                    ->url(fn (): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle'),               
                'assets'=> MenuItem::make()
                        ->label('Assets')
                        ->icon('fluentui-web-asset-20-o')
                        ->url('/admin/assets', shouldOpenInNewTab: false),
                'subscription'=> MenuItem::make()
                        ->label('Subscription')
                        ->icon('lineawesome-file-invoice-dollar-solid')
                        ->url('/admin/billing', shouldOpenInNewTab: false),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->plugins([
                FilamentEditProfilePlugin::make()
                    ->setTitle('Profile')
                    ->setNavigationLabel('Profile')
                    ->setNavigationGroup('Account')
                    ->setIcon('heroicon-o-user')
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowBrowserSessionsForm(false)
                    ->setSort(2)
            ])
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
