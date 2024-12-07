<?php

namespace App\Http\Controllers;

use App\Services\StoresService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    protected StoresService $service;

    public function __construct(StoresService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $stores = $this->service->all();
        return response()->json($stores, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:stores,email',
            'password' => 'required|string|min:6',
            'address' => 'required|string|max:150',
        ]);

        $data['password'] = bcrypt($data['password']);
        $store = $this->service->create($data);
        return response()->json($store, 201);
    }

    public function show($id): JsonResponse
    {
        $store = $this->service->find($id);
        return response()->json($store, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|unique:stores, email',
            'password' => 'sometimes|string|min:6',
            'address' => 'sometimes|string|max:150'
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $store = $this->service->update($id, $data);
        return response()->json($store, 200);
    }

    public function destroy($id): Response
    {
        $this->service->delete($id);
        return response()->noContent();
    }
}
