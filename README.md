# WhatsApp Gateway SaaS (Laravel + Node.js)

This repository provides a starter SaaS architecture for a WhatsApp gateway similar to Wapiar. It combines a Laravel API for tenant management, billing, and orchestration, plus a Node.js gateway service that manages WhatsApp Web QR pairing and message delivery.

## Architecture

- **Laravel API (`backend/`)**
  - Tenants, users, plans, API keys
  - Orchestration for device sessions
  - Webhooks and message queueing
- **Node.js Gateway (`node-gateway/`)**
  - WhatsApp Web session manager
  - QR generation & session lifecycle
  - Message send/receive and status callbacks
- **Modules (`modules/`)**
  - WooCommerce plugin stub
  - WHMCS gateway module stub

## Quick start (local)

1. Configure environment variables for the API and gateway.
2. Start the Node.js gateway service.
3. Run the Laravel app (requires Composer install).
4. Use the API to create a tenant and request a QR.

## Notes

This is a scaffold for a full SaaS gateway. Production deployments should use a queue worker, database, and Redis-backed session storage.
