<?php

namespace App\Providers;

use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->modalHeading('Paneles disponibles')
                ->modalWidth('sm')
                ->slideOver()
                ->labels([
                    'admin' => 'Panel de Administrador',
                    'personal' => __('Personal Panel'),
                ])->visible(function (): bool {

                    /** @var \App\Models\User|null $user */
                    $user = Auth::user();

                    return $user?->hasAnyRole([
                        'super_admin',
                    ]) ?? false;
                })
            ;
        });
    }
}
