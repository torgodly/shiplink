<?php

namespace App\Providers\Filament;

use App\Filament\Office\Pages\Login;
use App\Filament\Office\Widgets\StatsOverview;
use App\Filament\Widgets\StatusChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class OfficePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_START,
                fn() => view('branches.sidebar-nav-start')
            )
            ->id('office')
            ->path('office')
            ->databaseNotifications()
            ->font('Cairo')
            ->emailVerification()
            ->plugin(BreezyCore::make()
                ->myProfile(
                    shouldRegisterUserMenu: true,
                    shouldRegisterNavigation: false,
                    hasAvatars: true,
                    slug: 'my-profile'
                )->enableTwoFactorAuthentication()

            )
            ->brandLogo(asset('images/logo.png'))
            ->favicon(asset('images/fav.png'))
            ->sidebarCollapsibleOnDesktop()
            ->brandLogoHeight('2.5rem')
            ->brandName('ShipLink')
            ->login(Login::class)
            ->viteTheme('resources/css/filament/office/theme.css')
            ->colors([
                'primary' => '#247DFF',
                'secondary' => '#FADD02',
                'sky' => Color::Sky,
                'sun' => Color::Gray,
                'green' => Color::Green,
                'blue' => Color::Blue,
                'yellow' => Color::Yellow,
                'orange' => Color::Orange,
                'purple' => Color::Purple,
                'graysh' => Color::Gray,

            ])
            ->discoverResources(in: app_path('Filament/Office/Resources'), for: 'App\\Filament\\Office\\Resources')
            ->discoverPages(in: app_path('Filament/Office/Pages'), for: 'App\\Filament\\Office\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Office/Widgets'), for: 'App\\Filament\\Office\\Widgets')
            ->widgets([
                StatsOverview::class,
                StatusChart::class
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
