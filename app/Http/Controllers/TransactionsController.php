<?php

namespace App\Http\Controllers;

use App\Services\TransactionsService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    protected TransactionsService $service;

    public function __construct(TransactionsService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $transactions = $this->service->all();
        return response()->json($transactions, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'clients_id' => 'required|exists:clients,id',
            'stores_id' => 'required|exists:stores,id',
            'point_changes' => 'required|integer',
            'type' => 'required|in:accumulate,redeem',
            'reason' => 'nullable|string|max:150'
        ]);

        $transaction = $this->service->create($data);
        return response()->json($transaction, 201);
    }

    public function show($id): JsonResponse
    {
        $transaction = $this->service->find($id);
        return response()->json($transaction, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'clients_id' => 'sometimes|exists:clients,id',
            'stores_id' => 'sometimes|exists:stores,id',
            'point_changes' => 'sometimes|integer',
            'type' => 'sometimes|in:accumulate, redeem',
            'reason' => 'nullable|string|max:150'
        ]);

        $transaction = $this->service->update($id, $data);
        return response()->json($transaction, 200);
    }

    public function destroy($id): Response
    {
        $this->service->delete($id);
        return response()->noContent();
    }
}
