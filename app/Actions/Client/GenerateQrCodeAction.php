<?php

namespace App\Actions\Client;

use App\Services\ClientsService;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\JsonResponse;

class GenerateQrCodeAction
{
    public function __construct(ClientsService $service)
    {
        $this->service = $service;
    }

    public function __invoke($id): JsonResponse
    {
        $client = $this->service->find($id);

        if (!$client) {
            return response()->json(['message' => 'Cliente não encontrado.'],
                404);
        }

        $qrData = [
            'clients_id' => $client->id,
            'name' => $client->name,
            'email' => $client->email,
            'phone_number' => $client->phone_number
        ];

        $qrCode = QrCode::size(300)->generate(json_encode($qrData));
        return response()->json(['qr_code' => $qrCode], 200);
    }
}