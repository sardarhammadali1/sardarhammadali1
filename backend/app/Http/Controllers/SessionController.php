<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Tenant;
use App\Services\WhatsAppGatewayClient;

class SessionController extends Controller
{
    public function create(Request $request, Tenant $tenant, WhatsAppGatewayClient $client): JsonResponse
    {
        $payload = $request->validate([
            'label' => 'required|string|max:80',
        ]);

        $session = $client->createSession($tenant, $payload['label']);

        return response()->json([
            'data' => $session,
        ], 201);
    }

    public function qr(Tenant $tenant, string $session, WhatsAppGatewayClient $client): JsonResponse
    {
        $qr = $client->getQrCode($tenant, $session);

        return response()->json([
            'data' => [
                'session_id' => $session,
                'qr' => $qr,
            ]
        ]);
    }
}
