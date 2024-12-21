<?php

namespace App\Actions\Transaction;

use App\Services\TransactionsService;
use Illuminate\Http\JsonResponse;

class ShowAction
{
    protected TransactionsService $service;

    public function __construct(TransactionsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(int $id): JsonResponse
    {
        return response()->json($this->service->find($id), 200);
    }
}