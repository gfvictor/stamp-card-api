<?php

namespace App\Actions\Store;

use App\Services\StoresService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateAction
{
    protected StoresService $service;

    public function __construct(StoresService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|unique:stores,email',
            'password' => 'sometimes|string|min:6',
            'address' => 'sometimes|string|max:150'
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return response()->json($this->service->update($id, $data), 200);
    }
}