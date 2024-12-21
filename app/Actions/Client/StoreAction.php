<?php

namespace App\Actions\Client;

use App\Services\ClientsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreAction
{
    protected ClientsService $service;

    public function __construct(ClientsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string|digits:11|unique:clients,phone_number',
        ]);

        $data['password'] = bcrypt($data['password']);

        return response()->json($this->service->create($data), 201);
    }
}
