# Node.js WhatsApp Gateway

This service is responsible for WhatsApp Web session handling (QR generation, connection lifecycle, message delivery).

## Environment

- `PORT`: HTTP port (default 3001)
- `SESSION_STORE`: optional backing store (redis/sql) in production

## TODO for production

- Replace placeholder QR payload with actual WhatsApp Web session management (e.g., using Baileys or whatsapp-web.js).
- Persist sessions and media.
- Add webhook callbacks to Laravel.
