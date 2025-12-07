<?php

namespace App\Repositories;

use App\Contracts\FeatureFlagRepositoryInterface;
use App\Models\FeatureFlag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class FeatureFlagRepository implements FeatureFlagRepositoryInterface
{
    public function __construct(
        protected string $cacheKeyPrefix = 'ff:',
        protected int $cacheTTL = 60
    ) {
        $this->cacheKeyPrefix = $cacheKeyPrefix;
        $this->cacheTTL = $cacheTTL;
    }

    public function findByKey(string $key): ?FeatureFlag
    {
        return Cache::remember("{$this->cacheKeyPrefix}{$key}", $this->cacheTTL, function () use ($key) {
            return FeatureFlag::where('key', $key)->first();
        });
    }

    public function all(): Collection
    {
        return Cache::remember("{$this->cacheKeyPrefix}all", $this->cacheTTL, function () {
            return FeatureFlag::all();
        });
    }

    public function clearCache(): void
    {
        Cache::forget("{$this->cacheKeyPrefix}all");
        Cache::flush();
    }
}