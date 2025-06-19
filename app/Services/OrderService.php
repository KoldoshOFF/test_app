<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
class OrderService
{
    public function getOrders(array $filters): LengthAwarePaginator
    {
        return Order::query()
            ->when(isset($filters['dateFrom']), fn ($q) => $q->where('date', '>=', $filters['dateFrom']))
            ->when(isset($filters['dateTo']), fn ($q) => $q->where('date', '<=', $filters['dateTo']))
            ->paginate($filters['limit'] ?? 500);
    }
}
