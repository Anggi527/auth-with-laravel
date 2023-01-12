<?php

use App\Http\Controllers\AuthController;
use App\http\Controllers\menuController;
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
Route::get('/register', [AuthController::class, 'regis'])->name('register');
Route::post('/register', [AuthController::class, 'valiregis'])->name('valiregistrasi');

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'valilogin'])->name('valilogin');

Route::get('/forgotpassword', [AuthController::class, 'forgot'])->middleware('guest')->name('password.forgot');
Route::post('/forgotpassword', [AuthController::class, 'forgotpassword'])->middleware('guest')->name('password.email');

Route::get('/resetpassword/{token}', [AuthController::class, 'showresetpassword'])->name('password.reset');
Route::post('/resetpassword', [AuthController::class, 'resetpassword'])->name('password.update');


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/dashboard', [menuController::class, 'dashboard'])->name('dashboard')->middleware('auth');

