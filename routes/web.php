<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\StudentController;
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
    Route::prefix('student')->group(function(){
        Route::get('/', [StudentController::class, 'index'])->name('student');
        Route::post('/', [StudentController::class, 'create'])->name('student.create');
        Route::put('/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('/{id}', [StudentController::class, 'delete'])->name('student.delete');
    });
    Route::prefix('lesson')->group(function(){
        Route::get('/', [LessonController::class, 'index'])->name('lesson');
        Route::get('/add', [LessonController::class, 'add'])->name('lesson.add');
        Route::post('/add', [LessonController::class, 'create'])->name('lesson.create');
        Route::get('/{id}', [LessonController::class, 'edit'])->name('lesson.edit');
        Route::put('/{id}', [LessonController::class, 'update'])->name('lesson.update');
        Route::delete('/{id}', [LessonController::class, 'delete'])->name('lesson.delete');

        // Quiz
        Route::get('/{id}/quiz', [QuizController::class, 'index'])->name('quiz');
        Route::post('/{id}/quiz', [QuizController::class, 'create'])->name('quiz.create');
        Route::delete('/{id}/quiz/{quizId}', [QuizController::class, 'delete'])->name('quiz.delete');
        //Question
        Route::get('/{id}/quiz/{quizId}', [QuestionController::class, 'index'])->name('question');
        Route::get('/{id}/quiz/{quizId}/result', [QuestionController::class, 'result'])->name('question.result');
        Route::post('/{id}/quiz/{quizId}', [QuestionController::class, 'create'])->name('question.create');
        Route::delete('/{id}/quiz/{quizId}/delete/{questionId}', [QuestionController::class, 'delete'])->name('question.delete');
        // Result
        Route::get('/{id}/quiz/{quizId}/result/{userAnswer}', [QuestionController::class, 'resultDetail'])->name('question.result.detail');
        Route::post('/{id}/quiz/{quizId}/result/{userAnswer}', [QuestionController::class, 'resultEssayEvaluate'])->name('question.result.detail.evaluate');

    });
});

Route::middleware('guest')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('login', [AuthController::class, 'doLogin'])->name('auth.doLogin');
    });
});
