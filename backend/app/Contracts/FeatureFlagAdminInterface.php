<?php

namespace App\Contracts;

use App\Models\FeatureFlag;
use Illuminate\Support\Collection;

interface FeatureFlagAdminInterface
{
    public function create(array $data): FeatureFlag;
    public function update(FeatureFlag $featureFlag, array $data): bool;
    public function delete(FeatureFlag $featureFlag): bool;
    public function index(): Collection;
}