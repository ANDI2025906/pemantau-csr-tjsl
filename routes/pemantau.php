<?php

use Illuminate\Support\Facades\Route;

Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
