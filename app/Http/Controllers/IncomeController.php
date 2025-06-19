<?php

namespace App\Http\Controllers;


use App\Http\Requests\IncomeRequest;
use App\Http\Resources\IncomeResource;
use App\Services\IncomeService;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    protected $incomeService;

    public function __construct(IncomeService $incomeService)
    {
        $this->incomeService = $incomeService;
    }

    public function index(IncomeRequest $request)
    {
        $incomes = $this->incomeService->getIncomes($request->validated());

        return IncomeResource::collection($incomes);
    }
}
