<?php

namespace App\Actions\Client;

use App\Services\ClientsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DestroyAction
{
    protected ClientsService $service;

    public function __construct(ClientsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(int $id): JsonResponse
    {
        $this->service->delete($id);

        return response()->json(['message' => 'Cliente deletado com sucesso.'], 200);
    }
}