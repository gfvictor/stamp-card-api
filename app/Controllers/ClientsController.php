<?php

namespace App\Controllers;

use App\Actions\Client\DestroyAction;
use App\Actions\Client\GenerateQrCodeAction;
use App\Actions\Client\IndexAction;
use App\Actions\Client\ShowAction;
use App\Actions\Client\StoreAction;
use App\Actions\Client\UpdateAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientsController extends Controller
{

    public function index(IndexAction $action): JsonResponse
    {
        return $action();
    }

    public function store(StoreAction $action, Request $request): JsonResponse
    {
        return $action($request);
    }

    public function show(ShowAction $action, int $id): JsonResponse
    {
        return $action($id);
    }

    public function update(UpdateAction $action, Request $request, int $id): JsonResponse
    {
        return $action($request, $id);
    }

    public function destroy(DestroyAction $action, int $id): JsonResponse
    {
        return $action($id);
    }

    public function generateQrCode(GenerateQrCodeAction $action, int $id): JsonResponse
    {
        return $action($id);
    }

}
