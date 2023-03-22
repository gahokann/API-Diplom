<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [App\Http\Controllers\Api\RegisterController::class, 'register']);
Route::post('login', [App\Http\Controllers\Api\RegisterController::class, 'login']);

Route::name('profile.')->prefix('profile')->group(function(){
    Route::get('index', [App\Http\Controllers\Api\ProfileController::class, 'index'])->name("index")->middleware('auth:api'); // Главная страница пользователя
    Route::get('settings', [App\Http\Controllers\Api\ProfileController::class, 'index'])->name("settings")->middleware('auth:api'); // Страница настроек пользователя
    Route::get('company', [App\Http\Controllers\Api\ProfileController::class, 'company'])->name("company")->middleware('auth:api'); // Страница подтверждение компании

    // TODO: Function

    Route::patch('settings/fio', [App\Http\Controllers\Api\ProfileController::class, 'changeFIO'])->name("changeFIO")->middleware('auth:api'); // Изменение ФИО пользователя
    Route::patch('settings/email', [App\Http\Controllers\Api\ProfileController::class, 'changeEmail'])->name("changeEmail")->middleware('auth:api'); // Изменение Email пользователя
    Route::patch('settings/phone', [App\Http\Controllers\Api\ProfileController::class, 'changePhone'])->name("changePhone")->middleware('auth:api'); // Изменение Номера телефона пользователя
    Route::patch('settings/password', [App\Http\Controllers\Api\ProfileController::class, 'changePassword'])->name("changePassword")->middleware('auth:api'); // Изменение Пароля пользователя
});

Route::name('order.')->prefix('order')->group(function(){
    Route::get('index', [App\Http\Controllers\Api\OrderController::class, 'index'])->name("index"); // Все заказы пользователя
    Route::get('activity', [App\Http\Controllers\Api\OrderController::class, 'index'])->name("activity")->middleware('auth:api'); // Активные заказы пользователя
    Route::get('show/{id}', [App\Http\Controllers\Api\OrderController::class, 'show'])->name("show")->middleware('auth:api'); // Просмотр определённого заказа

    // TODO: Function
    Route::post('store', [App\Http\Controllers\Api\OrderController::class, 'store'])->name("store")->middleware('auth:api'); // Оформление заказа
    Route::patch('update/{id}', [App\Http\Controllers\Api\OrderController::class, 'update'])->name("update")->middleware('auth:api'); // Оформление заказа

});
