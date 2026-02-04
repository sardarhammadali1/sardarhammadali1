# Laravel API

This directory is a scaffold for a Laravel API that manages tenants and orchestrates the WhatsApp gateway.

## Required setup

- Install dependencies with Composer.
- Configure database and queue.
- Configure `WAGATEWAY_BASE_URL` to point to the Node.js gateway service.

## Suggested integrations

Add an HTTP macro (in `AppServiceProvider`) for `Http::gateway()` that injects the base URL and token:

```php
Http::macro('gateway', function () {
    return Http::baseUrl(config('wagateway.base_url'))
        ->withToken(config('wagateway.token'))
        ->acceptJson();
});
```
