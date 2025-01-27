<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Monitor; // Pastikan class controller di-import dengan benar
use App\Http\Controllers\broad; // Pastikan class controller di-import dengan benar


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

Route::get('/voucher', [Monitor::class, 'index'])->name('monitor');
// Route::get('/voucher.{id}', [Monitor::class, 'show'])->name('cek');

// Route::get('voucher/detail.{id,tgl1,tgl2}', [Monitor::class, 'show'])->name('cek');
Route::get('voucher_detail.{id}.{tgl1}.{tgl2}', [Monitor::class, 'show'])->name('cek');

Route::get('/broad', [broad::class, 'index'])->name('broad');

Route::post('/post-data', [broad::class, 'postData'])->name('post');  // Untuk mengirim data ke API

