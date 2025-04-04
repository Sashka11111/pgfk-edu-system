<?php

namespace Liamtseva\PGFKEduSystem\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class HomePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('home')
            ->path('home')
            ->colors([
                'primary' => "#4c1997",
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label(__('Profile'))
                    ->url(fn () => url('/profile'))
                    ->icon('heroicon-o-user-circle'),
            ])
            ->brandLogo(asset('images/icon.png'))
            ->favicon(asset('images/icon.png'))
            ->discoverResources(in: app_path('Filament/Home/Resources'), for: 'Liamtseva\\PGFKEduSystem\\Filament\\Home\\Resources')
            ->discoverPages(in: app_path('Filament/Home/Pages'), for: 'Liamtseva\\PGFKEduSystem\\Filament\\Home\\Pages')
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Home/Widgets'), for: 'Liamtseva\\PGFKEduSystem\\Filament\\Home\\Widgets')
            ->widgets([])
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
