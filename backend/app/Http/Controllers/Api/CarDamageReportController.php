<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarDamageReport;
use App\Contracts\CarDamageReportRepositoryInterface;
use Illuminate\Http\Request;

class CarDamageReportController extends Controller
{
    public function __construct(
        private CarDamageReportRepositoryInterface $repository,
    ) {
    }

    public function index()
    {
        return CarDamageReport::orderByDesc('created_at')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $report = $this->repository->create($data);

        return response()->json($report, 201);
    }

    public function show(CarDamageReport $carDamageReport)
    {
        return $this->repository->findById($carDamageReport->id);
    }

    public function update(Request $request, CarDamageReport $carDamageReport)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:open,in_review,closed',
        ]);

        $this->repository->update($carDamageReport, $data);

        return response()->json($carDamageReport);
    }

    public function destroy(CarDamageReport $carDamageReport)
    {
        $this->repository->delete($carDamageReport);

        return response()->json(null, 204);
    }
}
