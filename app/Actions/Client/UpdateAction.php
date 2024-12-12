<?php

namespace App\Actions\Client;

use App\Services\ClientsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateAction
{
    protected ClientsService $service;

    public function __construct(ClientsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|unique:clients,email',
            'password' => 'sometimes|string|min:6',
            'phone_number' => 'sometimes|string|digits:11|unique:clients,phone_number',
        ]);

        $data['password'] = !empty($data['password']) ? bcrypt($data['password']) : $data['password'];

        return response()->json($this->service->update($id, $data), 200);
    }
}