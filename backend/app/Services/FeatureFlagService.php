<?php

namespace App\Services;

use App\Contracts\FeatureFlagLoggerInterface;
use App\Contracts\FeatureFlagRepositoryInterface;
use App\Contracts\FeatureFlagServiceInterface;
use Illuminate\Support\Carbon;

class FeatureFlagService implements FeatureFlagServiceInterface
{
    public function __construct(
        private FeatureFlagRepositoryInterface $repository,
        private FeatureFlagLoggerInterface $logger,
    ) {
    }

    public function isEnabled(string $key, ?string $userIdentifier = null, array $context = []): bool
    {
        $flag = $this->repository->findByKey($key);

        if (!$flag) {
            $this->logger->logDecision($key, $userIdentifier, 'off', $context);
            return false;
        }

        $now = Carbon::now();

        if ($flag->starts_at && $now->lessThan($flag->starts_at)) {
            $this->logger->logDecision($key, $userIdentifier, 'off', $context);
            return false;
        }

        if ($flag->ends_at && $now->greaterThan($flag->ends_at)) {
            $this->logger->logDecision($key, $userIdentifier, 'off', $context);
            return false;
        }

        if (!$flag->enabled) {
            $this->logger->logDecision($key, $userIdentifier, 'off', $context);
            return false;
        }

        $conditions = $flag->conditions ?? [];
        if (isset($conditions['country'])) {
            $country = $context['country'] ?? null;
            if (!$country || !in_array($country, $conditions['country'], true)) {
                $this->logger->logDecision($key, $userIdentifier, 'off', $context);
                return false;
            }
        }

        $this->logger->logDecision($key, $userIdentifier, 'on', $context);
        return true;
    }

    public function getAllForContext(?string $userIdentifier = null, array $context = []): array
    {
        $flags = $this->repository->all();

        $result = [];

        foreach ($flags as $flag) {
            $result[$flag->key] = $this->isEnabled(
                $flag->key,
                $userIdentifier,
                $context
            );
        }

        return $result;
    }
}
