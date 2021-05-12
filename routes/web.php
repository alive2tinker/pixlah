<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ScreenController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/screen_detach/{screen}/{object}/{type}', [ScreenController::class, 'detach'])->name('screen.detach');
Route::get('/screen_resource/{screen}', [ScreenController::class, 'resource']);
Route::get('/show/{screen}', [ScreenController::class, 'showScreen'])->name('showScreen');
Route::get('/assignAttachment/{screen}/{attachment}', [ScreenController::class, 'assignAttachment'])->name('assignAttachment');
Route::get('/assignMessage/{screen}/{message}', [ScreenController::class, 'assignMessage'])->name('assignMessage');
Route::resource('screens', ScreenController::class);
Route::resource('attachments', AttachmentController::class);
Route::resource('messages', MessageController::class);
