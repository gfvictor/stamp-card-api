<?php

namespace App\Controllers;

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
            'yen_per_point' => 'required|integer|min:1',
            'discount_amount' => 'nullable|integer|min:1',
            'discount_type' => 'nullable|in:cash,percentage',
            'expiration_in_months' => 'nullable|integer|between:1,12'
        ]);

        $data['discount_amount'] = $data['discount_amount'] ?? 0;
        $data['discount_type'] = $data['discount_type'] ?? null;
        $data['expiration_in_months'] = $data['expiration_in_months'] ?? null;

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
            'rule_name' => 'sometimes|string|max:50',
            'rule_description' => 'sometimes|string|max:150'
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
