<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        // Custom route groups based on roles
        $this->mapCompanyRoutes();
        $this->mapPemantauRoutes();
        $this->mapAdminRoutes();
    }

    /**
     * Define the routes for companies.
     */
    protected function mapCompanyRoutes(): void
    {
        Route::middleware(['web', 'auth', 'role:perusahaan'])
            ->prefix('company')
            ->as('company.')
            ->group(base_path('routes/company.php'));
    }

    /**
     * Define the routes for monitors.
     */
    protected function mapPemantauRoutes(): void
    {
        Route::middleware(['web', 'auth', 'role:pemantau'])
            ->prefix('pemantau')
            ->as('pemantau.')
            ->group(base_path('routes/pemantau.php'));
    }

    /**
     * Define the routes for admins.
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'auth', 'role:admin'])
            ->prefix('admin')
            ->as('admin.')
            ->group(base_path('routes/admin.php'));
    }
}
