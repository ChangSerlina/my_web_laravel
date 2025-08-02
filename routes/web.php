<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParkingFeeController;
use App\Http\Controllers\ParkingFeeCheckController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;

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

// 後台.Google OAuth 登入
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google'); // ⬅️ 給路由命名
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// 發送測試信
// Route::get('/sendTestMail', [MailController::class, 'send']);

// 前台.電子郵件驗證
Route::get('/email/verify', [MailController::class, 'notice'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [MailController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [MailController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// 登入
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 關於我
Route::get('/contact', [ContactController::class, 'report_show'])->name('report_show');
Route::post('/contact/store', [ContactController::class, 'reporting'])->name('reporting');

// 停車費查詢
Route::get('/parkingFee', [ParkingFeeController::class, 'parkingFee_show'])->name('parkingFee_show');
Route::get('/captchaImage', [ParkingFeeController::class, 'create_captcha'])->name('create_captcha');
Route::post('/parkingFee', [ParkingFeeController::class, 'check_captcha'])->name('check_captcha');
// 停車費查詢結果
Route::post('/parkingFeeCheck', [ParkingFeeCheckController::class, 'parkingFeeCheck_show'])->name('parkingFeeCheck_show');

// 首頁
Route::get('/{page_chose?}', [HomeController::class, 'home_show'])->name('home_show');
