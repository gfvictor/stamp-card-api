<?php

namespace App\Actions\Store;

use App\Services\StoresService;
use Illuminate\Http\JsonResponse;

class DestroyAction
{
    protected StoresService $service;

    public function __construct(StoresService $service)
    {
        $this->service = $service;
    }

    public function __invoke(int $id): JsonResponse
    {
        $this->service->delete($id);

        return response()->json(['message' => 'Cliente deletado com sucesso.'], 200);
    }
}