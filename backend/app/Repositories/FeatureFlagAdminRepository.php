<?php

namespace App\Repositories;

use App\Contracts\FeatureFlagAdminInterface;
use App\Models\FeatureFlag;
use Illuminate\Support\Collection;

class FeatureFlagAdminRepository implements FeatureFlagAdminInterface
{
    public function create(array $data): FeatureFlag
    {
        return FeatureFlag::create($data);
    }

    public function update(FeatureFlag $featureFlag, array $data): bool
    {
        return $featureFlag->update($data);

    }

    public function delete(FeatureFlag $featureFlag): bool
    {
        return $featureFlag->delete();
    }

    public function index(): Collection
    {
        return FeatureFlag::orderBy('key')->get();
    }
}