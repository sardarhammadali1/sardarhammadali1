<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\Http;

class WhatsAppGatewayClient
{
    public function createSession(Tenant $tenant, string $label): array
    {
        $response = Http::gateway()->post('/sessions', [
            'tenant_id' => $tenant->id,
            'label' => $label,
        ]);

        return $response->json('data') ?? [];
    }

    public function getQrCode(Tenant $tenant, string $sessionId): string
    {
        $response = Http::gateway()->get("/sessions/{$sessionId}/qr", [
            'tenant_id' => $tenant->id,
        ]);

        return (string) ($response->json('data.qr') ?? '');
    }

    public function sendMessage(Tenant $tenant, string $sessionId, string $to, string $message): array
    {
        $response = Http::gateway()->post('/messages', [
            'tenant_id' => $tenant->id,
            'session_id' => $sessionId,
            'to' => $to,
            'message' => $message,
        ]);

        return $response->json('data') ?? [];
    }
}
