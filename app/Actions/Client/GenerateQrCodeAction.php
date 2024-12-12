<?php

namespace App\Actions\Client;

use App\Services\ClientsService;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\JsonResponse;

class GenerateQrCodeAction
{
    protected ClientsService $service;

    public function __construct(ClientsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(int $id): JsonResponse
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

        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        return response()->json(['qr_code' => $writer->writeString
        (json_encode($qrData))], 200);
    }
}