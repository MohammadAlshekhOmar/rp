<?php

use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DeleteController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\ProviderRateController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceRateController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WarrantyController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
 */

Broadcast::routes(); // for /broadcasting/auth

Route::get('login', function () {
    if (auth()->guard('admin')->user()) {
        return redirect()->route('admin.cp');
    }
    return view('Admin.login');
})->name('admin.login');

Route::post('login', [LoginController::class, 'authenticate'])->name('admin.login');

Route::group(['middleware' => ['auth:admin'], 'as' => 'admin.'], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('cp', [HomeController::class, 'cp'])->name('cp');

    Route::get('swap', [LanguageController::class, 'swap'])->name('swap');

    Route::group(['prefix' => 'ads', 'as' => 'ads.'], function () {
        Route::controller(AdController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_ADS');
            Route::get('find', 'find')->name('find')->can('VIEW_ADS');
            Route::post('add', 'add')->name('add')->can('CREATE_ADS');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_ADS');
            Route::post('accept', 'accept')->name('accept')->can('ACCEPT_ADS');
            Route::post('reject', 'reject')->name('reject')->can('REJECT_ADS');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_ADS');
    });

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_USERS');
            Route::get('show', 'show')->name('show')->can('SHOW_USERS');
            Route::get('show-add', 'showAdd')->name('showAdd')->can('CREATE_USERS');
            Route::post('add', 'add')->name('add')->can('CREATE_USERS');
            Route::get('show-edit', 'showEdit')->name('showEdit')->can('UPDATE_USERS');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_USERS');
            Route::get('export', 'export')->name('export')->can('VIEW_USERS');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_USERS');
    });

    Route::group(['prefix' => 'providers', 'as' => 'providers.'], function () {
        Route::controller(ProviderController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_PROVIDERS');
            Route::get('show', 'show')->name('show')->can('SHOW_PROVIDERS');
            Route::get('show-add', 'showAdd')->name('showAdd')->can('CREATE_PROVIDERS');
            Route::post('add', 'add')->name('add')->can('CREATE_PROVIDERS');
            Route::get('show-edit', 'showEdit')->name('showEdit')->can('UPDATE_PROVIDERS');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_PROVIDERS');
            Route::get('export', 'export')->name('export')->can('VIEW_PROVIDERS');
            Route::post('delete-image', 'deleteImage')->name('delete.image')->can('VIEW_PROVIDERS');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_PROVIDERS');
    });

    Route::group(['prefix' => 'providerRates', 'as' => 'providerRates.'], function () {
        Route::controller(ProviderRateController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_PROVIDERSRATES');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_PROVIDERSRATES');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::controller(RoleController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_ROLES');
            Route::get('show-add', 'showAdd')->name('showAdd')->can('CREATE_ROLES');
            Route::post('add', 'add')->name('add')->can('CREATE_ROLES');
            Route::get('show-edit', 'showEdit')->name('showEdit')->can('UPDATE_ROLES');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_ROLES');
            Route::post('delete', 'delete')->name('delete')->can('DELETE_ROLES');
        });
    });

    Route::group(['prefix' => 'admins', 'as' => 'admins.'], function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_ADMINS');
            Route::get('show-add', 'showAdd')->name('showAdd')->can('CREATE_ADMINS');
            Route::post('add', 'add')->name('add')->can('CREATE_ADMINS');
            Route::get('show-edit', 'showEdit')->name('showEdit')->can('UPDATE_ADMINS');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_ADMINS');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_ADMINS');
    });

    Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
        Route::controller(ServiceController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_SERVICES');
            Route::get('show', 'show')->name('show')->can('SHOW_SERVICES');
            Route::get('show-add', 'showAdd')->name('showAdd')->can('CREATE_SERVICES');
            Route::post('add', 'add')->name('add')->can('CREATE_SERVICES');
            Route::get('show-edit', 'showEdit')->name('showEdit')->can('UPDATE_SERVICES');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_SERVICES');
            Route::post('delete-image', 'deleteImage')->name('delete.image')->can('VIEW_SERVICES');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_SERVICES');
    });

    Route::group(['prefix' => 'serviceRates', 'as' => 'serviceRates.'], function () {
        Route::controller(ServiceRateController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_SERVICESRATES');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_SERVICESRATES');
    });

    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::controller(OrderController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_ORDERS');
            Route::get('show', 'show')->name('show')->can('VIEW_ORDERS');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_ORDERS');
    });

    Route::group(['prefix' => 'invoices', 'as' => 'invoices.'], function () {
        Route::controller(InvoiceController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_INVOICES');
            Route::get('show', 'show')->name('show')->can('VIEW_INVOICES');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_INVOICES');
    });

    Route::group(['prefix' => 'warranties', 'as' => 'warranties.'], function () {
        Route::controller(WarrantyController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_WARRANTIES');
            Route::get('show', 'show')->name('show')->can('VIEW_WARRANTIES');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_WARRANTIES');
    });

    Route::group(['prefix' => 'notifications', 'as' => 'notifications.'], function () {
        Route::controller(NotificationController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_NOTIFICATIONS');
            Route::get('show', 'show')->name('show')->can('SHOW_NOTIFICATIONS');
            Route::get('show-add', 'showAdd')->name('showAdd')->can('CREATE_NOTIFICATIONS');
            Route::post('add', 'add')->name('add')->can('CREATE_NOTIFICATIONS');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_NOTIFICATIONS');
    });

    Route::group(['prefix' => 'paymentMethods', 'as' => 'paymentMethods.'], function () {
        Route::controller(PaymentMethodController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_PAYMENTMETHODS');
            Route::get('find', 'find')->name('find')->can('VIEW_PAYMENTMETHODS');
            Route::post('add', 'add')->name('add')->can('CREATE_PAYMENTMETHODS');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_PAYMENTMETHODS');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_PAYMENTMETHODS');
    });

    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::controller(CategoryController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_CATEGORIES');
            Route::get('find', 'find')->name('find')->can('VIEW_CATEGORIES');
            Route::post('add', 'add')->name('add')->can('CREATE_CATEGORIES');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_CATEGORIES');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_CATEGORIES');
    });

    Route::group(['prefix' => 'regions', 'as' => 'regions.'], function () {
        Route::controller(RegionController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_REGIONS');
            Route::get('find', 'find')->name('find')->can('VIEW_REGIONS');
            Route::post('add', 'add')->name('add')->can('CREATE_REGIONS');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_REGIONS');
        });

        Route::post('delete', DeleteController::class)->name('delete')->can('DELETE_REGIONS');
    });

    Route::group(['prefix' => 'infos', 'as' => 'infos.'], function () {
        Route::controller(InfoController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_INFOS');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_INFOS');
        });
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::controller(SettingController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_SETTINGS');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_SETTINGS');
        });
    });
});
