<?php

namespace App\Services;


use App\Models\Income;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IncomeService
{
    public function getIncomes(array $filters): LengthAwarePaginator
    {
        return Income::query()
            ->when(isset($filters['dateFrom']), fn ($q) => $q->where('date', '>=', $filters['dateFrom']))
            ->when(isset($filters['dateTo']), fn ($q) => $q->where('date', '<=', $filters['dateTo']))
            ->paginate($filters['limit'] ?? 500);
    }
}
