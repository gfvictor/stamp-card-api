<?php

namespace App\Controllers;

use App\Models\Clients;
use App\Models\Points;
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

    public function grantPoints(Request $request): JsonResponse
    {
        $data = $request->validate([
            'qr_code_data' => 'required|string',
            'stores_id' => 'required|exists:stores,id',
            'point_changes' => 'required|integer|min:1',
            'reason' => 'nullable|string'
        ]);

        $qrData = json_decode($data['qr_code_data'], true);

        if (!$qrData || !isset($qrData['clients_id'],
                $qrData['phone_number'])) {
            return response()->json(['message' => 'Dados do QR code são inválidos'], 422);
        }

        $client = Clients::where('id', $qrData['clients_id'])
            ->where('phone_number', $qrData['phone_number'])
            ->first();

        if (!$client) {
            return response()->json(['message' => "Cliente não encontrado ou número de telefone não condiz ao cliente"]);
        }

        $transactions = $this->service->create([
            'clients_id' => $client->id,
            'stores_id' => $data['stores_id'],
            'point_changes' => $data['point_changes'],
            'type' => 'accumulate',
            'reason' => $data['reason'] ?? 'Pontos creditados via QR Code.'
        ]);

        Points::create([
            'clients_id' => $client->id,
            'stores_id' =>  $data['stores_id'],
            'transactions_id' => $transactions->id,
            'points' => $data['point_changes']
        ]);

        return response()->json($transactions, 201);
    }

    }
