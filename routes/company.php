<?php

use Illuminate\Support\Facades\Route;

Route::get('/profile', [CompanyProfileController::class, 'show'])->name('profile');
Route::get('/profile/create', [CompanyProfileController::class, 'create'])->name('profile.create');
Route::post('/profile', [CompanyProfileController::class, 'store'])->name('profile.store');
