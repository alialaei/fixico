<?php

namespace App\Logging;

use App\Contracts\FeatureFlagLoggerInterface;
use App\Models\FeatureFlagLog;

class DatabaseFeatureFlagLogger implements FeatureFlagLoggerInterface
{
    public function logDecision(
        string $flagKey,
        ?string $userIdentifier,
        string $decision,
        array $context = []
    ): void {
        FeatureFlagLog::create([
            'flag_key' => $flagKey,
            'user_identifier' => $userIdentifier,
            'decision' => $decision,
            'context' => $context,
        ]);
    }

}