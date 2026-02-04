<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'name' => 'required|string|max:120',
            'plan' => 'required|string|max:80',
            'callback_url' => 'nullable|url'
        ]);

        $tenant = Tenant::create($payload);

        return response()->json([
            'data' => $tenant,
        ], 201);
    }
}
