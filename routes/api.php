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
| be assigned to the "API" middleware group. Make something great!
|
*/

Route::post('register', [App\Http\Controllers\API\RegisterController::class, 'register']);
Route::post('login', [App\Http\Controllers\API\RegisterController::class, 'login']);

Route::name('profile.')->prefix('profile')->group(function(){
    Route::get('index', [App\Http\Controllers\API\ProfileController::class, 'index'])->name("index")->middleware('auth:api'); // Главная страница пользователя
    Route::get('settings', [App\Http\Controllers\API\ProfileController::class, 'index'])->name("settings")->middleware('auth:api'); // Страница настроек пользователя
    Route::get('company', [App\Http\Controllers\API\ProfileController::class, 'company'])->name("company")->middleware('auth:api'); // Страница подтверждение компании
    Route::get('orderUser', [App\Http\Controllers\API\OrderController::class, 'orderUser'])->name("orderUser")->middleware('auth:api'); // Заказы пользователя
    Route::get('notification', [App\Http\Controllers\API\NotificationController::class, 'show'])->name("notification")->middleware('auth:api'); // Уведомление пользователя

    // TODO: Function

    Route::patch('settings/fio', [App\Http\Controllers\API\ProfileController::class, 'changeFIO'])->name("changeFIO")->middleware('auth:api'); // Изменение ФИО пользователя
    Route::patch('notification/isRead', [App\Http\Controllers\API\NotificationController::class, 'read'])->name("read")->middleware('auth:api'); // Пользователь прочитал уведомление
    Route::patch('settings/email', [App\Http\Controllers\API\ProfileController::class, 'changeEmail'])->name("changeEmail")->middleware('auth:api'); // Изменение Email пользователя
    Route::patch('settings/phone', [App\Http\Controllers\API\ProfileController::class, 'changePhone'])->name("changePhone")->middleware('auth:api'); // Изменение Номера телефона пользователя
    Route::patch('settings/password', [App\Http\Controllers\API\ProfileController::class, 'changePassword'])->name("changePassword")->middleware('auth:api'); // Изменение Пароля пользователя
    Route::post('company/add', [App\Http\Controllers\API\CompanyController::class, 'store'])->name("companyAdd")->middleware('auth:api'); // Добавление компании
    Route::post('notification/delete', [App\Http\Controllers\API\NotificationController::class, 'delete'])->name("notDelete")->middleware('auth:api'); // Удаление уведомления
    Route::post('changeImage', [App\Http\Controllers\API\UserController::class, 'changeImage'])->name("changeImage")->middleware('auth:api'); // Имзенение картинки пользователя
});

Route::name('order.')->prefix('order')->group(function(){
    Route::get('activity', [App\Http\Controllers\API\OrderController::class, 'index'])->name("activity")->middleware('auth:api'); // Активные заказы пользователя
    Route::get('show/{id}', [App\Http\Controllers\API\OrderController::class, 'show'])->name("show")->middleware('auth:api'); // Просмотр определённого заказа

    // TODO: Function
    Route::post('store', [App\Http\Controllers\API\OrderController::class, 'store'])->name("store")->middleware('auth:api'); // Оформление заказа
    Route::patch('update/{id}', [App\Http\Controllers\API\OrderController::class, 'update'])->name("update")->middleware('auth:api'); // Редактирование заказа
});

Route::name('admin.')->prefix('admin')->group(function(){
    Route::get('allUser', [App\Http\Controllers\API\UserController::class, 'allUser'])->name("allUser")->middleware('auth:api'); //Все пользователи системы
    Route::get('employees', [App\Http\Controllers\API\UserController::class, 'employees'])->name("employees")->middleware('auth:api'); // Все сотрудники системы
    Route::get('roles', [App\Http\Controllers\API\RoleController::class, 'index'])->name("index")->middleware('auth:api'); // Все роли системы
    Route::get('orderAll', [App\Http\Controllers\API\OrderController::class, 'orderAll'])->name("orderAll")->middleware('auth:api'); // Все заказы системы
    Route::get('companyAll', [App\Http\Controllers\API\CompanyController::class, 'companyAll'])->name("companyAll")->middleware('auth:api'); // Все компании системы
    Route::get('partnerAll', [App\Http\Controllers\API\PartnerController::class, 'show'])->name("partnerAll")->middleware('auth:api'); // Все партнеры системы
    Route::get('orderEmployee', [App\Http\Controllers\API\OrderController::class, 'orderEmployee'])->name("orderEmployee")->middleware('auth:api'); // Заказы в работе у сотрудника
    Route::get('userShow/{id}', [App\Http\Controllers\API\UserController::class, 'userShow'])->name("userShow")->middleware('auth:api'); // Страница пользователя
    Route::get('employeeShow/{id}', [App\Http\Controllers\API\UserController::class, 'employeeShow'])->name("employeeShow")->middleware('auth:api'); // Страница сотрудника

    Route::post('companyStatus', [App\Http\Controllers\API\CompanyController::class, 'statusCompany'])->name("statusCompany")->middleware('auth:api'); // Изменение статуса компании
    Route::post('partnerStore', [App\Http\Controllers\API\PartnerController::class, 'store'])->name("partnerStore")->middleware('auth:api'); // Добавление партнера в систему
    Route::post('partnerDelete', [App\Http\Controllers\API\PartnerController::class, 'delete'])->name("partnerDelete")->middleware('auth:api'); // Удаление партнера из системы
    Route::post('changeRole', [App\Http\Controllers\API\UserController::class, 'changeRole'])->name("changeRole")->middleware('auth:api'); // Изменение роли в системе
    Route::post('orderWork', [App\Http\Controllers\API\OrderController::class, 'orderWork'])->name("orderWork")->middleware('auth:api'); // Взятие сотрудником заказа в работу
    Route::post('removeEmployeeOrder', [App\Http\Controllers\API\OrderController::class, 'removeEmployeeOrder'])->name("removeEmployeeOrder")->middleware('auth:api'); // Снятие сотрудника с заказа
    Route::post('orderStatus', [App\Http\Controllers\API\OrderController::class, 'changeStatus'])->name("changeStatus")->middleware('auth:api'); // Изменение статуса зазказа

});
