<?php

namespace App\Actions\Transaction;

use App\Services\TransactionsService;
use Illuminate\Http\JsonResponse;

class IndexAction
{
    protected TransactionsService $service;

    public function __construct(TransactionsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(): JsonResponse
    {
        return response()->json($this->service->all(), 200);
    }
}