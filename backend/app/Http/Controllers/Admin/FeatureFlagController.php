<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\FeatureFlagRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\FeatureFlag;
use Illuminate\Http\Request;
use App\Contracts\FeatureFlagAdminInterface;

class FeatureFlagController extends Controller
{
    public function __construct(
        private FeatureFlagRepositoryInterface $repository,
        private FeatureFlagAdminInterface $adminRepository,
    ) {
    }

    public function index()
    {
        $flags = $this->adminRepository->index();

        return view('admin.feature_flags.index', compact('flags'));
    }

    public function create()
    {
        return view('admin.feature_flags.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|max:255|unique:feature_flags,key',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'enabled' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $data['enabled'] = $request->boolean('enabled');

        $this->adminRepository->create($data);
        $this->repository->clearCache();

        return redirect()->route('admin.feature-flags.index');
    }

    public function edit(FeatureFlag $featureFlag)
    {
        return view('admin.feature_flags.edit', compact('featureFlag'));
    }

    public function update(Request $request, FeatureFlag $featureFlag)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'enabled' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $data['enabled'] = $request->boolean('enabled');

        $this->adminRepository->update($featureFlag, $data);

        $this->repository->clearCache();

        return redirect()->route('admin.feature-flags.index');
    }

    public function destroy(FeatureFlag $featureFlag)
    {
        $featureFlag->delete();

        $this->adminRepository->delete($featureFlag);

        return redirect()->route('admin.feature-flags.index');
    }

}
