<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Tips\TipsController;
use App\Http\Controllers\CodeExecution\CodeExecutionController;
use App\Http\Controllers\Game\LevelController;
use App\Http\Controllers\LeaderBoard\LeaderBoardController;
use App\Http\Controllers\TestBank\QuestionController;



Route::post('/update-level', [LevelController::class, 'updateLevel']);

Route::get('/user/levels/{id}', [LevelController::class, 'getUserLevels']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/tips/random', [TipsController::class, 'TipsFetch']); // Get a random tip


// PHP ROUTE TO EXECUTE
Route::post('/execute-php', [CodeExecutionController::class, 'execute']);
Route::post('/testbank-php', [CodeExecutionController::class, 'testbank']);


Route::get('/top-players', [LeaderBoardController::class, 'getTopPlayers']);

Route::get('/questions', [QuestionController::class, 'getQuestions']);
