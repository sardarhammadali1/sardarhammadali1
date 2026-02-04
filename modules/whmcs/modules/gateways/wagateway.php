<?php
/**
 * WHMCS WA Gateway Module
 */

if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

function wagateway_config()
{
    return [
        'FriendlyName' => [
            'Type' => 'System',
            'Value' => 'WhatsApp Gateway',
        ],
        'api_url' => [
            'FriendlyName' => 'API URL',
            'Type' => 'text',
            'Size' => '60',
        ],
        'api_token' => [
            'FriendlyName' => 'API Token',
            'Type' => 'password',
        ],
        'tenant_id' => [
            'FriendlyName' => 'Tenant ID',
            'Type' => 'text',
            'Size' => '32',
        ],
        'session_id' => [
            'FriendlyName' => 'Session ID',
            'Type' => 'text',
            'Size' => '32',
        ],
    ];
}

function wagateway_invoice_payment_received($params)
{
    $url = rtrim($params['api_url'], '/');
    $payload = [
        'session_id' => $params['session_id'],
        'to' => $params['clientdetails']['phonenumber'],
        'message' => sprintf('Payment received for invoice #%s', $params['invoiceid']),
    ];

    $ch = curl_init($url . '/v1/tenants/' . $params['tenant_id'] . '/messages');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $params['api_token'],
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}
