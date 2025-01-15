<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;

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

Route::get('/contact', [ContactController::class, 'report_show'])->name('report_show');
Route::post('/contact/store', [ContactController::class, 'reporting']) ->name('reporting');

Route::get('/{page_chose?}', [HomeController::class, 'home_show'])->name('home_show');