<?php

namespace App\Http\Controllers;

use App\Services\RulesService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RulesController extends Controller
{
    protected RulesService $service;

    public function __construct(RulesService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $rules = $this->service->all();
        return response()->json($rules, 200);
    }

    public function getRulesByStore($storeId): JsonResponse
    {
        $rules = $this->service->getRulesByStore($storeId);
        return response()->json($rules, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'stores_id' => 'required|exists:stores,id',
            'rule_name' => 'required|string|max:150',
            'rule_description' => 'nullable|string'
        ]);

        $rule = $this->service->createRule($data);
        return response()->json($rule, 201);
    }

    public function show($id): JsonResponse
    {
        $rule = $this->service->find($id);
        return response()->json($rule, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'rule_name' => 'sometimes|string|max:150',
            'rule_description' => 'nullable|string'
        ]);

        $rule = $this->service->updateRule($id, $data);
        return response()->json($rule, 200);
    }

    public function destroy($id): Response
    {
        $this->service->deleteRule($id);
        return response()->noContent();
    }
}
