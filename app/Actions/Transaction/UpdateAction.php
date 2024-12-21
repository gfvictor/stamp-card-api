<?php

namespace App\Actions\Transaction;

use App\Services\TransactionsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateAction
{
    protected TransactionsService $service;

    public function __construct(TransactionsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'clients_id' => 'sometimes|exists:clients,id',
            'stores_id' => 'sometimes|exists:stores,id',
            'point_changes' => 'sometimes|integer',
            'type' => 'sometimes|in:accumulate,redeem',
            'reason' => 'nullable|string|max:150'
        ]);

        return response()->json($this->service->update($id, $data), 200);
    }
}