<?php

namespace App\Http\Middleware;

use App\Contracts\FeatureFlagServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class EnsureFeatureEnabled
{

    public function __construct(
        private FeatureFlagServiceInterface $featureFlags
    ) {
        $this->featureFlags = App::make(FeatureFlagServiceInterface::class);
    }

    public function handle(Request $request, Closure $next, string $flagKey): Response
    {
        $userIdentifier = (string) ($request->user()->id ?? $request->query('user_id', 'guest'));
        $context = [
            'country' => $request->header('X-Country') ?? null,
        ];

        if (!$this->featureFlags->isEnabled($flagKey, $userIdentifier, $context)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'This feature is not available',
                ], 403);
            }

            abort(403, 'This feature is not available');
        }

        return $next($request);
    }
}
