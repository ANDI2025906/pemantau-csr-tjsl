<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use App\Models\User;

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
        Blade::component('auth-validation-errors', \App\View\Components\AuthValidationErrors::class);
        Blade::component('auth-card', \App\View\Components\AuthCard::class);
        Blade::component('application-logo', \App\View\Components\ApplicationLogo::class);
        Blade::component('input-label', View\Components\InputLabel::class);
        Blade::component('text-input', View\Components\TextInput::class);
        Blade::component('input-error', View\Components\InputError::class);
        Blade::component('primary-button', View\Components\PrimaryButton::class);
        // Fix untuk string length pada MySQL < 5.7.7
        Schema::defaultStringLength(191);

        // Force HTTPS in production
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Custom Blade directives for roles
        Blade::if('role', function($role) {
            return auth()->check() && auth()->user()->role === $role;
        });

        // Custom Blade directives for multiple roles
        Blade::if('hasAnyRole', function($roles) {
            return auth()->check() && in_array(auth()->user()->role, explode('|', $roles));
        });
    }
}
