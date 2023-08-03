<?php

use App\Http\Controllers\Both\AuthController;
use App\Http\Controllers\Both\CategoryController;
use App\Http\Controllers\Both\InfoController;
use App\Http\Controllers\Both\NotificationController;
use App\Http\Controllers\Both\PaymentMethodController;
use App\Http\Controllers\Both\ProfileController;
use App\Http\Controllers\Both\RegionController;
use App\Http\Controllers\Both\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Both Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['prefix' => 'auth'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login-phone', 'loginPhone');
        Route::post('active', 'active');
        Route::post('login-email', 'loginEmail');
        Route::post('forget', 'forget');
        Route::post('check-code', 'checkCode');
        Route::post('reset', 'reset');
    });
});

Route::group(['prefix' => 'regions'], function () {
    Route::controller(RegionController::class)->group(function () {
        Route::get('all', 'all');
    });
});

Route::group(['prefix' => 'settings'], function () {
    Route::controller(SettingController::class)->group(function () {
        Route::get('privacy-policy', 'privacyPolicy');
        Route::get('terms-conditions', 'termsConditions');
        Route::get('about-us', 'aboutUs');
    });
});

Route::group(['prefix' => 'infos'], function () {
    Route::controller(InfoController::class)->group(function () {
        Route::get('all', 'all');
    });
});

Route::middleware('BothAuth')->group(function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('logout', 'logout');
            Route::post('delete', 'delete');
        });
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('get', 'get');
            Route::post('change-language', 'changeLanguage');
            Route::post('change-password', 'changePassword');
        });
    });

    Route::group(['prefix' => 'notifications'], function () {
        Route::controller(NotificationController::class)->group(function () {
            Route::get('get', 'get');
        });
    });

    Route::group(['prefix' => 'paymentMethods'], function () {
        Route::controller(PaymentMethodController::class)->group(function () {
            Route::get('all', 'all');
        });
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::controller(CategoryController::class)->group(function () {
            Route::get('all', 'all');
        });
    });
});
