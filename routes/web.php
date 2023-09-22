<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PeriodController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth:admin')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    });

    Route::prefix('period')->group(function(){
        Route::get('/', [PeriodController::class, 'index'])->name('period');
        Route::post('/', [PeriodController::class, 'create'])->name('period.create');
        Route::post('/{id}/change', [PeriodController::class, 'changeStatus'])->name('period.change');
        Route::put('/{id}', [PeriodController::class, 'update'])->name('period.udpate');
        Route::delete('/{id}', [PeriodController::class, 'delete'])->name('period.delete');
    });
});

Route::middleware('guest')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('login', [AuthController::class, 'doLogin'])->name('auth.doLogin');
    });
});
