<?php

namespace App\Controllers;

use App\Services\PointsService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    protected PointsService $service;

    public function __construct(PointsService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $points= $this->service->all();
        return response()->json($points, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'clients_id' => 'required|exists:clients,id',
            'stores_id' => 'required|exists:stores,id',
            'transactions_id' => 'required|exists:transactions,id',
            'points' => 'required|integer'
        ]);

        $point = $this->service->createPoints($data);
        return response()->json($point, 201);
    }

    public function show($id): JsonResponse
    {
        $point = $this->service->find($id);
        return response()->json($point, 200);
    }

    public function destroy($id): Response
    {
        $this->service->delete($id);
        return response()->noContent();
    }

    public function getTotalPoints(Request $request): JsonResponse
    {
        $data = $request->validate([
            'clients_id' => 'required|exists:clients,id',
            'stores_id' => 'required|exists:stores,id'
        ]);

        $totalPoints = $this->service->getTotalPoints($data['clients_id'],
            $data['stores_id']);
        return response()->json(['total_points' => $totalPoints], 200);
    }
}
