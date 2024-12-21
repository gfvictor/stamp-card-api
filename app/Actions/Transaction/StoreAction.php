<?php

namespace App\Actions\Transaction;

use App\Services\TransactionsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreAction
{
    protected TransactionsService $service;

    public function __construct(TransactionsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'clients_id' => 'required|exists:clients,id',
            'stores_id' => 'required|exists:stores,id',
            'amount_spent' => 'required|integer|min:1',
            'type' => 'required|in:accumulate, redeem',
            'reason' => 'nullable|string|max:150'
        ]);

        return response()->json($this->service->create($data), 201);
    }
}