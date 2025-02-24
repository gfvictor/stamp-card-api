<?php

namespace App\Controllers;

use App\Actions\Store\DestroyAction;
use App\Actions\Store\IndexAction;
use App\Actions\Store\ShowAction;
use App\Actions\Store\StoreAction;
use App\Actions\Store\UpdateAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoresController extends Controller
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
}
