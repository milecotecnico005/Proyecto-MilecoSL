<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OrdenesTrabajoController;
use App\Http\Controllers\TelegramWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user', [AuthController::class, 'getUserApi']);
    Route::post('logout', [AuthController::class, 'logoutApi']);
});

Route::post('login', [AuthController::class, 'loginApi']);
Route::post('verifyLogin', [AuthController::class, 'verifyLogin']);

Route::post('register', [AuthController::class, 'registerApi']);

Route::get('orders/user/{id}', [AuthController::class, 'getOrdersByOperario']);

Route::get('orders/client/{id}', [AuthController::class, 'getOrdersByClient']);

Route::get('orders/{id}', [AuthController::class, 'getOrderById']);
Route::PUT('/orders/status/{id}', [AuthController::class, 'updateStatusOrder']);

Route::get('/projects', [AuthController::class, 'getAllprojects']);

Route::get('/products', [AuthController::class, 'getAllproducts']);

Route::post('/orders', [AuthController::class, 'storeOrdenesApi']);

Route::get('/getTrabajos/{orderId}', [AuthController::class, 'getTrabajosOfOrden']);

Route::get('/getAll/Orders/Pending', [AuthController::class, 'getAllOrdersPending']);

Route::get('/getAll/Orders', [AuthController::class, 'getAllOrders']);

Route::post('/generate/Order/By/Operario', [AuthController::class, 'generateOrderForOperario']);

Route::post('/telegram/webhook', [TelegramWebhookController::class, 'telegramWebhook']);