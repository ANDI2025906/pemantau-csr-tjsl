<?php

namespace App\Policies;

use App\Models\User;

class DashboardPolicy
{
    /**
     * Determine whether the user can view dashboard.
     */
    public function view(User $user): bool
    {
        return in_array($user->role, ['company', 'reviewer']);
    }

    /**
     * Determine whether the user can export reports.
     */
    public function exportReports(User $user): bool
    {
        return in_array($user->role, ['company', 'reviewer']);
    }
}
