<?php

namespace App\Actions\Store;

use App\Services\StoresService;
use Illuminate\Http\JsonResponse;

class IndexAction
{
    protected StoresService $service;

    public function __construct(StoresService $service)
    {
        $this->service = $service;
    }

    public function __invoke(): JsonResponse
    {
        return response()->json($this->service->all(), 200);
    }
}