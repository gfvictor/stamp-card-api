<?php

namespace App\Actions\Client;

use App\Services\ClientsService;
use Illuminate\Http\JsonResponse;

class IndexAction
{
    protected ClientsService $service;

    public function __construct(ClientsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(): JsonResponse
    {
        return response()->json($this->service->all(), 200);
    }
}