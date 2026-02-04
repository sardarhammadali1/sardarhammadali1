<?php
/**
 * Plugin Name: WA Gateway for WooCommerce
 * Description: Sends WooCommerce order notifications via the WhatsApp Gateway.
 * Version: 0.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('woocommerce_new_order', function ($orderId) {
    $order = wc_get_order($orderId);
    if (!$order) {
        return;
    }

    $apiUrl = get_option('wagateway_api_url');
    $token = get_option('wagateway_api_token');
    $sessionId = get_option('wagateway_session_id');
    $phone = $order->get_billing_phone();

    if (!$apiUrl || !$token || !$sessionId || !$phone) {
        return;
    }

    $message = sprintf(
        'Thanks for your order #%s. Total: %s',
        $order->get_order_number(),
        $order->get_formatted_order_total()
    );

    wp_remote_post($apiUrl . '/v1/tenants/' . get_option('wagateway_tenant_id') . '/messages', [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ],
        'body' => wp_json_encode([
            'session_id' => $sessionId,
            'to' => $phone,
            'message' => $message,
        ]),
    ]);
});
