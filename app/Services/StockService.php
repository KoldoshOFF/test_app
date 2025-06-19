<?php

namespace App\Services;


use App\Models\Stock;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StockService
{
    public function getStocks(array $filters): LengthAwarePaginator|array
    {
        $today = now()->format('Y-m-d');

        if (isset($filters['dateFrom']) && $filters['dateFrom'] !== $today) {
            return [
                'error' => true,
                'message' => 'Можно выгружать данные только за текущий день',
            ];
        }

        return Stock::query()
            ->whereDate('date', $today)
            ->paginate($filters['limit'] ?? 500);
    }
}
