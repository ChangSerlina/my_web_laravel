<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParkingFeeController;
use App\Http\Controllers\ParkingFeeCheckController;

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

// 關於我
Route::get('/contact', [ContactController::class, 'report_show'])->name('report_show');
Route::post('/contact/store', [ContactController::class, 'reporting'])->name('reporting');

// 停車費查詢
Route::get('/parkingFee', [ParkingFeeController::class, 'parkingFee_show'])->name('parkingFee_show');
Route::get('/captchaImage', [ParkingFeeController::class, 'create_captcha'])->name('create_captcha');
Route::post('/parkingFee', [ParkingFeeController::class, 'check_captcha'])->name('check_captcha');

Route::post('/parkingFeeCheck', [ParkingFeeCheckController::class, 'parkingFeeCheck_show'])->name('parkingFeeCheck_show');

// 首頁
Route::get('/{page_chose?}', [HomeController::class, 'home_show'])->name('home_show');
