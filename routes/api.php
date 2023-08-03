<?php

use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\WarrantyController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['prefix' => 'users'], function () {
    Route::post('add', [UserController::class, 'add']);
});

Route::middleware('auth:api')->group(function () {

    Broadcast::routes();

    Route::group(['prefix' => 'users'], function () {
        Route::controller(UserController::class)->group(function () {
            Route::post('edit', 'edit');
            Route::get('favorites', 'favorites');
            Route::post('favorite', 'favorite');
        });
    });

    Route::group(['prefix' => 'services'], function () {
        Route::controller(ServiceController::class)->group(function () {
            Route::get('all', 'all');
            Route::get('details', 'details');
            Route::post('rate', 'rate');
        });
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::controller(CategoryController::class)->group(function () {
            Route::post('details', 'details');
        });
    });

    Route::group(['prefix' => 'providers'], function () {
        Route::controller(ProviderController::class)->group(function () {
            Route::get('details', 'details');
            Route::post('rate', 'rate');
        });
    });

    Route::group(['prefix' => 'ads'], function () {
        Route::controller(AdController::class)->group(function () {
            Route::get('all', 'all');
        });
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::controller(OrderController::class)->group(function () {
            Route::get('my', 'my');
            Route::get('details', 'details');
            Route::post('add', 'add');
        });
    });

    Route::group(['prefix' => 'invoices'], function () {
        Route::controller(InvoiceController::class)->group(function () {
            Route::get('details', 'details');
        });
    });

    Route::group(['prefix' => 'warranties'], function () {
        Route::controller(WarrantyController::class)->group(function () {
            Route::get('all', 'all');
            Route::get('details', 'details');
        });
    });

    Route::group(['prefix' => 'chats'], function () {
        Route::controller(ChatController::class)->group(function () {
            Route::get('chat-list', 'chatList');
            Route::get('chat', 'chat');
            Route::post('send-message', 'sendMessage');
        });
    });
});
