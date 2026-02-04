<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\MessageController;

Route::prefix('v1')->group(function () {
    Route::post('/tenants', [TenantController::class, 'store']);
    Route::post('/tenants/{tenant}/sessions', [SessionController::class, 'create']);
    Route::get('/tenants/{tenant}/sessions/{session}/qr', [SessionController::class, 'qr']);
    Route::post('/tenants/{tenant}/messages', [MessageController::class, 'send']);
});
