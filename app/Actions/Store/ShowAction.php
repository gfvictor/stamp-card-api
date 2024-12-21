<?php

namespace App\Actions\Store;

use App\Services\StoresService;
use Illuminate\Http\JsonResponse;

class ShowAction
{
    protected StoresService $service;

    public function __construct(StoresService $service)
    {
        $this->service = $service;
    }

    public function __invoke(int $id): JsonResponse
    {
        return response()->json($this->service->find($id), 201);
    }
}