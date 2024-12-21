<?php

namespace App\Actions\Store;

use App\Services\StoresService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreAction
{
    protected StoresService $service;

    public function __construct(StoresService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'email' =>  'required|email|unique:stores,email',
            'password' => 'required|string|min:6',
            'address' => 'required|string|max:150',
        ]);

        $data['password'] = bcrypt($data['password']);

        return response()->json($this->service->create($data), 201);
    }
}