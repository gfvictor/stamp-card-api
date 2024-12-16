<?php

namespace App\Actions\Transaction;

use App\Services\TransactionsService;
use Illuminate\Http\JsonResponse;

class DestroyAction
{
    protected TransactionsService $service;

    public function __construct(TransactionsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(int $id): JsonResponse
    {
        $this->service->delete($id);

        return response()->json(['message' => 'Transação deletada com sucesso.'], 200);
    }
}