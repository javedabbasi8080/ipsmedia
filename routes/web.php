<?php

use App\Http\Controllers\AchievementsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);

Route::resource('comments', CommentController::class);
Route::resource('lessons-watched', LessonController::class);
