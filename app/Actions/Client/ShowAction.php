<?php

namespace App\Actions\Client;

use App\Services\ClientsService;
use Illuminate\Http\JsonResponse;

class ShowAction
{
    protected ClientsService $service;

    public function __construct(ClientsService $service)
    {
        $this->service = $service;
    }

    public function __invoke($id): JsonResponse
    {
        $client = $this->service->find($id);
        return response()->json($client, 200);
    }
}