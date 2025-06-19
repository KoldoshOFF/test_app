<?php

namespace App\Services;

use App\Http\Requests\SaleRequest;
use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SaleService
{
    public function getSale(array $filters): LengthAwarePaginator
    {
        return Sale::query()
            ->when(isset($filters['dateFrom']), fn ($q) => $q->where('date', '>=', $filters['dateFrom']))
            ->when(isset($filters['dateTo']), fn ($q) => $q->where('date', '<=', $filters['dateTo']))
            ->paginate($filters['limit'] ?? 500);
    }
}
