<?php

use App\Http\Controllers\Provider\AdController;
use App\Http\Controllers\Provider\ChatController;
use App\Http\Controllers\Provider\HomePageController;
use App\Http\Controllers\Provider\InvoiceController;
use App\Http\Controllers\Provider\OrderController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Provider\ServiceController;
use App\Http\Controllers\Provider\WarrantyController;
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

Route::group(['prefix' => 'providers'], function () {
    Route::post('add', [ProviderController::class, 'add']);
});

Route::middleware('auth:provider')->group(function () {

    Broadcast::routes();

    Route::group(['prefix' => 'homepage'], function () {
        Route::get('index', [HomePageController::class, 'homepage']);
    });

    Route::group(['prefix' => 'providers'], function () {
        Route::controller(ProviderController::class)->group(function () {
            Route::post('edit', 'edit');
        });
    });

    Route::group(['prefix' => 'services'], function () {
        Route::controller(ServiceController::class)->group(function () {
            Route::get('all', 'all');
            Route::post('add', 'add');
            Route::post('edit', 'edit');
            Route::post('delete', 'delete');
            Route::post('delete-image', 'deleteImage');
        });
    });

    Route::group(['prefix' => 'ads'], function () {
        Route::controller(AdController::class)->group(function () {
            Route::get('all', 'all');
            Route::post('add', 'add');
            Route::post('edit', 'edit');
            Route::post('delete', 'delete');
        });
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::controller(OrderController::class)->group(function () {
            Route::get('getByStatus', 'getByStatus');
            Route::get('details', 'details');
            Route::post('accept', 'accept');
            Route::post('reject', 'reject');
            Route::post('finish', 'finish');
        });
    });

    Route::group(['prefix' => 'invoices'], function () {
        Route::controller(InvoiceController::class)->group(function () {
            Route::get('details', 'details');
            Route::post('add', 'add');
        });
    });

    Route::group(['prefix' => 'warranties'], function () {
        Route::controller(WarrantyController::class)->group(function () {
            Route::get('all', 'all');
            Route::get('details', 'details');
            Route::post('add', 'add');
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
