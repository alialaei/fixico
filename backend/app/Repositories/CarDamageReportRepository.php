<?php

namespace App\Repositories;

use App\Contracts\CarDamageReportRepositoryInterface;
use App\Models\CarDamageReport;
use Illuminate\Support\Collection;

class CarDamageReportRepository implements CarDamageReportRepositoryInterface
{
    public function create(array $data): CarDamageReport
    {
        return CarDamageReport::create($data);
    }

    public function update(CarDamageReport $carDamageReport, array $data): bool
    {
        return $carDamageReport->update($data);
    }

    public function delete(CarDamageReport $carDamageReport): bool
    {
        return $carDamageReport->delete();
    }

    public function findById(int $id): ?CarDamageReport
    {
        return CarDamageReport::find($id);
    }

    public function findAll(): Collection
    {
        return CarDamageReport::all();
    }
}