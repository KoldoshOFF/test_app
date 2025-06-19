<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Http\Resources\StockResource;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index(StockRequest $request)
    {
        $result = $this->stockService->getStocks($request->validated());

        if (is_array($result) && $result['error'] ?? false) {
            return response()->json(['error' => $result['message']], 422);
        }

        return StockResource::collection($result);
    }
}
