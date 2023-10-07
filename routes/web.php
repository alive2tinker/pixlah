<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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





Route::get('/show/{screen}', [ScreenController::class, 'showScreen'])->name('showScreen');
Route::get('/orderIsServed/{order}', [OrderController::class, 'orderIsServed'])->name('orderIsServed');
Route::get('/orderIsServing/{order}', [OrderController::class, 'orderIsServing'])->name('orderIsServing');
Route::get('/update-orders/{screen}', [OrderController::class, 'updateOrders']);


Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::get('/', function () {
        return view('welcome');
    })->name('landing');

    Route::resource('/contacts', ContactController::class)->only('store');

    Route::post('update-colors/{screen}', [ScreenController::class, 'updateColors'])->name('updateScreenColors');

    Route::get('/assignAttachment/{screen}/{attachment}', [ScreenController::class, 'assignAttachment'])->name('assignAttachment');
    Route::get('/assignMessage/{screen}/{message}', [ScreenController::class, 'assignMessage'])->name('assignMessage');
    Route::resource('screens', ScreenController::class);
    Route::resource('attachments', AttachmentController::class);
    Route::resource('messages', MessageController::class);
    Route::get('/search', \App\Http\Controllers\SearchController::class)->name('search');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/screen_detach/{screen}/{object}/{type}', [ScreenController::class, 'detach'])->name('screen.detach');
    Route::get('/screen_resource/{screen}', [ScreenController::class, 'resource']);
    Auth::routes();
});
