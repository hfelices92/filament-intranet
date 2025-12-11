<?php

namespace App\Providers\Filament;


use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;

use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;

class PersonalPanelProvider extends PanelProvider
{
    public function isAdmin(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = filament()->auth()->user();

        return $user &&  $user->hasRole('super_admin');
    }
    
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('personal')
            ->path('personal')
            ->login()
            ->default()
            ->databaseNotifications()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Personal/Resources'), for: 'App\Filament\Personal\Resources')
            ->discoverPages(in: app_path('Filament/Personal/Pages'), for: 'App\Filament\Personal\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Personal/Widgets'), for: 'App\Filament\Personal\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
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
            ])
            ->plugins([
                 FilamentShieldPlugin::make()->registerNavigation(fn (): bool => $this->isAdmin()),
                 SpotlightPlugin::make(),
            ])
            ->navigationItems([
               NavigationItem::make()
                    ->label('Volver al Panel Admin')
                    ->url('/admin')
                    ->icon('heroicon-o-arrow-left')
                    ->group('Administración')
                    ->hidden($this->isAdmin() === false)
                    ->sort(1),
            ])
            ->userMenuItems([
                 Action::make('navigate-to-admin-panel')
                    ->label('Volver al Panel Admin')
                    ->url('/admin')
                    ->icon('heroicon-o-arrow-left')
                    ->visible(fn (): bool => $this->isAdmin())
                  ,
                   Action::make('navigate-to-admin-panel')
                    ->label('Volver al Panel Personal')
                    ->url('/personal')
                    ->icon('heroicon-o-arrow-left')
                    ->visible(fn (): bool => $this->isAdmin())
                  ,
                
            ])
            // ->topNavigation()
           ;
             
    }
}
