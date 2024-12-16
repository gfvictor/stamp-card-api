<?php

namespace App\Actions\Transaction;

use App\Models\Clients;
use App\Models\Points;
use App\Models\Rules;
use App\Services\TransactionsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GrantPointsAction
{
    protected TransactionsService $service;

    public function __construct(TransactionsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'qr_code_data' => 'required|string',
            'stores_id' => 'required|exists:stores,id',
            'amount_spent' => 'required|integer|min:1',
            'reason' => 'nullable|string'
        ]);

        $qrData = json_decode($data['qr_code_data'], true);
        if (!$qrData || empty($qrData['clients_id']) || empty($qrData['phone_number'])) {
            return response()->json(['message' => 'Dados do QR Code não são válidos.'], 422);
        }

        $client = Clients::where('id', $qrData['clients_id'])
            ->where('phone_number', $qrData['phone_number'])
            ->first();
        if (!$client) {
            return response()->json(['message' => 'Cliente não encontrado ou número de telefone não condiz ao cliente.'], 404);
        }

        $storeRule = Rules::where('stores_id', $data['stores_id'])->first();
        if (!$storeRule || $storeRule->yen_per_point <= 0) {
            return response()->json(['message' => 'Regra da loja não encontrada ou inválida.'],
                404);
        }

        $calculatePoints = intdiv($data['amount_spent'], $storeRule->yen_per_point);
        if ($calculatePoints <= 0) {
            return response()->json(['message' => 'O montante gasto não gera pontos suficientes'], 422);
        }

        $existingPoints = Points::where('clients_id', $client->id)
            ->where('stores_id', $data['stores_id'])
            ->sum('points');

        $totalPoints = $existingPoints + $calculatePoints;

        $transaction = $this->service->create([
            'clients_id' => $client->id,
            'stores_id' => $data['stores_id'],
            'amount_spent' => $data['amount_spent'],
            'point_changes' => $calculatePoints,
            'type' => 'accumulate',
            'reason' => $data['reason'] ?? 'Pontos creditados via QR Code!',
        ]);

        Points::upsert([
            [
                'clients_id' => $client->id,
                'stores_id' => $data['stores_id'],
                'transactions_id' => $transaction->id,
                'points' => $totalPoints,
                ],
            ],
            ['clients_id', 'stores_id'],
            ['points']
        );

        return response()->json($transaction, 201);
    }
}