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

    public function __invoke(int $id): JsonResponse
    {
        return response()->json($this->service->find($id), 200);
    }
}