<?php

namespace App\Contracts;

interface FeatureFlagLoggerInterface
{
    public function logDecision(
        string $flagKey,
        ?string $userIdentifier,
        string $decision,
        array $context = []
    ): void;
}