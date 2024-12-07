<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\ClientsService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    protected ClientsService $service;

    public function __construct(ClientsService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $clients = $this->service->all();
        return response()->json($clients, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:clients,email',
            'phone_number' => 'required|string|max:11|unique:clients,phone_number',
            'password' => 'required|string|min:6'
        ]);

        $data['password'] = bcrypt($data['password']);
        $client = $this->service->create($data);
        return response()->json($client, 201);
    }

    public function show($id)
    {
        $client = $this->service->find($id);
        return response()->json($client, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|unique:clients,email',
            'password' => 'sometimes|string|min:6',
            'phone_number' => 'sometimes|string|max:11|unique:clients,phone_number',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $client = $this->service->update($id, $data);
        return response()->json($client, 200);
    }

    public function destroy($id): Response
    {
        $this->service->delete($id);
        return response()->noContent();
    }

    public function generateQrCode($id): JsonResponse
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
