<?php

namespace App\Controllers;

use App\Actions\Transaction\DestroyAction;
use App\Actions\Transaction\GrantPointsAction;
use App\Actions\Transaction\IndexAction;
use App\Actions\Transaction\ShowAction;
use App\Actions\Transaction\StoreAction;
use App\Actions\Transaction\UpdateAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionsController extends Controller
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

    public function grantPoints(GrantPointsAction $action, Request $request): JsonResponse
    {
        return $action($request);
    }
}
