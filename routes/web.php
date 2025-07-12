<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\CsrCategoryController;
use App\Http\Controllers\CsrIndicatorController;
use App\Http\Controllers\CsrAssessmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Registration Routes
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Logout Route
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Dashboard Routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');
            
        Route::get('/timeline', [DashboardController::class, 'getTimelineData'])
            ->name('dashboard.timeline');
            
        Route::get('/export', [DashboardController::class, 'exportReport'])
            ->name('dashboard.export')
            ->middleware('can:export-reports');
    });

    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Company Profile Routes
    Route::prefix('company-profile')->group(function () {
        Route::get('/', [CompanyProfileController::class, 'index'])
            ->name('company.profile.index');
        Route::get('/create', [CompanyProfileController::class, 'create'])
            ->name('company.profile.create');
        Route::post('/', [CompanyProfileController::class, 'store'])
            ->name('company.profile.store');
        Route::get('/{id}/edit', [CompanyProfileController::class, 'edit'])
            ->name('company.profile.edit');
        Route::put('/{id}', [CompanyProfileController::class, 'update'])
            ->name('company.profile.update');
    });

    // CSR Routes
    Route::resources([
        'csr-categories' => CsrCategoryController::class,
        'csr-indicators' => CsrIndicatorController::class,
        'csr-assessments' => CsrAssessmentController::class,
    ]);

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])
            ->name('markAllAsRead');
        Route::post('/{id}/mark-read', [NotificationController::class, 'markAsRead'])
            ->name('markAsRead');
    });
});

// Remove this line since we've included auth routes above
// require __DIR__.'/auth.php';
