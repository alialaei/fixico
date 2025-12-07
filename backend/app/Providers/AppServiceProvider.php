<?php

namespace App\Providers;

use App\Contracts\FeatureFlagRepositoryInterface;
use App\Contracts\FeatureFlagLoggerInterface;
use App\Contracts\FeatureFlagServiceInterface;
use App\Repositories\FeatureFlagRepository;
use App\Logging\DatabaseFeatureFlagLogger;
use App\Services\FeatureFlagService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\CarDamageReportRepositoryInterface;
use App\Repositories\CarDamageReportRepository;
use App\Contracts\FeatureFlagAdminInterface;
use App\Repositories\FeatureFlagAdminRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public $bindings = [
        FeatureFlagRepositoryInterface::class => FeatureFlagRepository::class,
        FeatureFlagLoggerInterface::class => DatabaseFeatureFlagLogger::class,
        FeatureFlagServiceInterface::class => FeatureFlagService::class,
        CarDamageReportRepositoryInterface::class => CarDamageReportRepository::class,
        FeatureFlagAdminInterface::class => FeatureFlagAdminRepository::class,
    ];
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
