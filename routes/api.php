<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware(['isPeriod', 'auth:sanctum'])->group(function(){
        Route::get('lessons', [LessonController::class, 'all']);
        Route::get('lesson/{id}', [LessonController::class, 'get']);
        Route::get('quizes', [QuizController::class, 'all']);
    });
});
