<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tips\TipsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EducatorController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\AuthController;

Route::get('/', function () {
    return view('auth.login');
});



    Route::controller(AuthController::class)->group(function () {
        Route::get('/login',  'showLoginForm')
        ->name('login');

        Route::post('/login/process',  'login')
        ->name('login.submit');

        Route::post('/logout',  'logout')
        ->name('logout');

    });


    Route::middleware(['admin'])->group(function () {

        Route::controller(AdminController::class)->group(function () {

            Route::get('/dashboard', 'dashboard')
            ->name('dashboard.index');

        });

        Route::controller(PlayerController::class)->group(function () {

            Route::get('/player', 'index')
            ->name('player.index');

        });

        Route::controller(EducatorController::class)->group(function () {

            Route::get('/educators', 'index')
            ->name('educators.index');

            Route::post('/educators/store', 'store')
            ->name('educators.store');

            Route::put('/educator/update/{id}','update')
            ->name('educator.update');

            Route::delete('/educator/delete/{id}', 'destroy')
            ->name('educator.delete');

        });

        Route::controller(AdminController::class)->group(function () {

            Route::get('/admins', 'index')
            ->name('admins.index');

            Route::post('/admins/store', 'store')
            ->name('admins.store');


            Route::put('/admin/update/{id}', 'update')
            ->name('admin.update');


            Route::delete('/admin/delete/{id}', 'destroy')
            ->name('admin.delete');


        });

        Route::controller(TipsController::class)->group(function () {

            Route::get('/tips', 'tips')
            ->name('admin.tips');

            Route::post('/tips/store', 'store')
            ->name('tips.store');
        });

    });
