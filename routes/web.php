<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tips\TipsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EducatorController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\LeaderBoard\LeaderBoardController;
use App\Http\Controllers\Reports\EngagementController;
use App\Http\Controllers\TestBank\QuestionController;

Route::get('/', function () {
    return view('welcome');
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

        Route::controller(LeaderBoardController::class)->group(function () {
            Route::get('/leaderboards', 'leaderboards')
            ->name('admin.leaderboard');

            Route::get('/analytics-report', 'analyticsreport')
            ->name('analytics.report');

        });

        Route::controller(EngagementController::class)->group(function () {
            // Route::get('/engagement', 'engagment')
            // ->name('reports.engagements');

            Route::get('/logs', 'logs')
            ->name('code.logs');

            Route::get('/progress','progress')
            ->name('user.progress');

            Route::get('/quiz-performance','testProgress')
            ->name('user.test_progress');
        });



        Route::controller(QuestionController::class)->group(function () {

            Route::get('/testbank', 'index')
            ->name('testbank.index');

            Route::post('/testbank', 'store')
            ->name('testbank.store');

            Route::get('/testbank/{question}/edit', 'edit')
            ->name('testbank.edit');

            Route::put('/testbank/{question}', 'update')
            ->name('testbank.update');

            Route::delete('/testbank/{question}', 'destroy')
            ->name('testbank.destroy');

        });

    });

    Route::get('/db-check', function () {
        return response()->json([
            'mysql' => DB::connection('mysql')->select("SELECT DATABASE() as db_name"),
            'sql_db' => DB::connection('sql_db')->select("SELECT DATABASE() as db_name"),
        ]);
    });

    Route::controller(PlayerController::class)->group(function () {

    Route::get('/player', 'index')->name('player.index');

    // Add player
    Route::post('/player/store', 'store')->name('players.store');

    // Update player
    Route::put('/player/update/{id}', 'update')->name('players.update');

    // Delete player
    Route::delete('/player/delete/{id}', 'destroy')->name('players.destroy');

});

