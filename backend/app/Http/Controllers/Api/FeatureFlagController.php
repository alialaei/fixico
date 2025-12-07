<?php

namespace App\Http\Controllers\Api;

use App\Contracts\FeatureFlagServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeatureFlagController extends Controller
{
    public function __construct(
        private FeatureFlagServiceInterface $featureFlags,
    ) {
    }

    public function index(Request $request)
    {
        $userIdentifier = $request->query('user_id', 'guest');
        $context = [
            'country' => $request->query('country'),
        ];

        $flags = $this->featureFlags->getAllForContext($userIdentifier, $context);

        return response()->json($flags);
    }
}
