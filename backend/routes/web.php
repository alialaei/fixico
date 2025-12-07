<?php

use App\Http\Controllers\Admin\FeatureFlagController as AdminFeatureFlagController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('feature-flags', AdminFeatureFlagController::class)
        ->except(['show']);
});
