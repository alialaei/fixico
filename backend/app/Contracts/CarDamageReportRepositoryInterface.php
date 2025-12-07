<?php

namespace App\Contracts;

use Illuminate\Support\Collection;
use App\Models\CarDamageReport;

interface CarDamageReportRepositoryInterface
{
    public function create(array $data): CarDamageReport;
    public function update(CarDamageReport $carDamageReport, array $data): bool;
    public function delete(CarDamageReport $carDamageReport): bool;
    public function findById(int $id): ?CarDamageReport;
    public function findAll(): Collection;
}