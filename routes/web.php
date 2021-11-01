<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\BestAnswerController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::get('/questions', [QuestionController::class, 'index']);
Route::get('/questions/{question}', [QuestionController::class, 'show']);

Route::post('/questions/{question}/answers', [AnswerController::class, 'store']);
Route::post('/answers/{answer}/best', [BestAnswerController::class, 'store'])->name('best-answers.store');
Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');
