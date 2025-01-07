<?php

use App\Http\Controllers\API\LinkApiController;
use App\Http\Controllers\API\QrcodeApiController;
use App\Http\Controllers\API\UserApiController;
use App\Http\Controllers\API\UserManagementApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public Routes (Tidak perlu token)
Route::post('/login', [UserApiController::class, 'store']);
Route::post('/login_user', [UserApiController::class, 'login']);
Route::middleware('auth_api:sanctum')->post('/logout', [UserApiController::class, 'logout']);

Route::middleware('auth_app_token')->group(function () {
    Route::get('/qrcodes_api', [QrCodeApiController::class, 'indexApi']);
    Route::post('/qrcodes_api', [QrCodeApiController::class, 'storeQrcode']);
    Route::delete('/qrcodes_api/{id}', [QrCodeApiController::class, 'destroy']);
});

Route::middleware('auth_app_token')->group(function () {
    Route::get('/link_api', [LinkApiController::class, 'indexApi']);
    Route::post('/link_api', [LinkApiController::class, 'storeLink']);
    Route::put('/link_api/{id}', [LinkApiController::class, 'updateLink']);
    Route::delete('/link_api/{id}', [LinkApiController::class, 'destroyLink']);
    Route::put('/link_api/{id}/update-expired', [LinkApiController::class, 'updateExpiredApi']);
    Route::put('/link_api/{id}/update-password', [LinkApiController::class, 'updatePasswordApi']);
    Route::put('/link_api/{id}/remove-expiration', [LinkApiController::class, 'removeExpirationDateApi']);
    Route::put('/link_api/{id}/remove-password', [LinkApiController::class, 'removePasswordApi']);
});

Route::middleware(['auth_app_token', 'check_admin_role'])->group(function () {
    Route::get('/users_management', [UserManagementApiController::class, 'index']);
    Route::put('/users_management/{id}/role', [UserManagementApiController::class, 'updateRole']);
});

