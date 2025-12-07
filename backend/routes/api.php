<?php

use App\Http\Controllers\Api\CarDamageReportController;
use App\Http\Controllers\Api\FeatureFlagController;
use Illuminate\Support\Facades\Route;

Route::get('/feature-flags', [FeatureFlagController::class, 'index']);

Route::get('/reports', [CarDamageReportController::class, 'index']);
Route::post('/reports', [CarDamageReportController::class, 'store'])
    ->middleware('feature:enable_report_creation');
Route::get('/reports/{carDamageReport}', [CarDamageReportController::class, 'show']);
Route::put('/reports/{carDamageReport}', [CarDamageReportController::class, 'update'])
    ->middleware('feature:enable_report_editing');
Route::delete('/reports/{carDamageReport}', [CarDamageReportController::class, 'destroy'])
    ->middleware('feature:enable_report_deletion');