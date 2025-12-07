<?php

namespace App\Contracts;

interface FeatureFlagServiceInterface
{
    public function isEnabled(string $key, ?string $userIdentifier = null, array $context = []): bool;

    public function getAllForContext(?string $userIdentifier = null, array $context = []): array;
}