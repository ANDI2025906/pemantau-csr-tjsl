<?php

namespace App\Providers;

use App\Models\CsrAssessment;
use App\Models\Dashboard;
use App\Models\User;
use App\Policies\CsrAssessmentPolicy;
use App\Policies\DashboardPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        CsrAssessment::class => CsrAssessmentPolicy::class,
        Dashboard::class => DashboardPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define role-based access gates
        Gate::define('access-company-features', function (User $user) {
            return $user->role === 'perusahaan';
        });

        Gate::define('access-pemantau-features', function (User $user) {
            return $user->role === 'pemantau';
        });

        Gate::define('access-admin-features', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('access-reviewer-features', function (User $user) {
            return $user->role === 'reviewer';
        });

        // Dashboard permissions
        Gate::define('view-dashboard', function (User $user) {
            return in_array($user->role, ['admin', 'perusahaan', 'pemantau', 'reviewer']);
        });

        Gate::define('export-reports', function (User $user) {
            return in_array($user->role, ['admin', 'pemantau', 'reviewer']);
        });

        // Assessment permissions
        Gate::define('create-assessment', function (User $user) {
            return in_array($user->role, ['admin', 'perusahaan']);
        });

        Gate::define('edit-assessment', function (User $user) {
            return in_array($user->role, ['admin', 'perusahaan']);
        });

        Gate::define('delete-assessment', function (User $user) {
            return in_array($user->role, ['admin']);
        });

        Gate::define('review-assessments', function (User $user) {
            return in_array($user->role, ['admin', 'reviewer', 'pemantau']);
        });

        // Company profile permissions
        Gate::define('manage-company-profile', function (User $user) {
            return in_array($user->role, ['admin', 'perusahaan']);
        });

        // CSR category permissions
        Gate::define('manage-csr-categories', function (User $user) {
            return in_array($user->role, ['admin']);
        });

        // CSR indicator permissions
        Gate::define('manage-csr-indicators', function (User $user) {
            return in_array($user->role, ['admin']);
        });

        // Notification permissions
        Gate::define('manage-notifications', function (User $user) {
            return in_array($user->role, ['admin', 'perusahaan', 'pemantau', 'reviewer']);
        });

        // Super admin bypass - harus di akhir
        Gate::before(function (User $user) {
            if ($user->role === 'admin') {
                return true;
            }
        });
    }
}
