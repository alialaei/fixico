<?php

namespace App\Contracts;

use App\Models\FeatureFlag;
use Illuminate\Support\Collection;

interface FeatureFlagRepositoryInterface
{
    public function findByKey(string $key): ?FeatureFlag;

    public function all(): Collection;

    public function clearCache(): void;


}