<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Tenant;
use App\Services\WhatsAppGatewayClient;

class MessageController extends Controller
{
    public function send(Request $request, Tenant $tenant, WhatsAppGatewayClient $client): JsonResponse
    {
        $payload = $request->validate([
            'session_id' => 'required|string',
            'to' => 'required|string',
            'message' => 'required|string',
        ]);

        $delivery = $client->sendMessage($tenant, $payload['session_id'], $payload['to'], $payload['message']);

        return response()->json([
            'data' => $delivery,
        ]);
    }
}
