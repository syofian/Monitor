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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [Monitor::class, 'index'])->name('monitor');
// Route::get('/voucher.{id}', [Monitor::class, 'show'])->name('cek');

// Route::get('voucher/detail.{id,tgl1,tgl2}', [Monitor::class, 'show'])->name('cek');
Route::get('voucher_detail.{id}.{tgl1}.{tgl2}', [Monitor::class, 'show'])->name('cek');
Route::post('/post-data', [broad::class, 'postData'])->name('post');  // Untuk mengirim data ke API

Route::get('/broad', [broad::class, 'index'])->name('broad');
Route::post('/kirim-nama/{startDate}.{endDate}', [broad::class, 'kirimData'])->name('kirim');  // Untuk mengirim data ke API
Route::post('/kirimself/{kode}', [broad::class, 'selfKirim'])->name('selfKirim');  // Untuk mengirim data ke API

Route::get('/showfile', [broad::class, 'showfile'])->name('showfile');
Route::post('/fileManual/{pengirim}', [broad::class, 'fileManual'])->name('fileManual');
Route::post('/fileKirim', [broad::class, 'fileKirim'])->name('fileKirim');


Route::post('/import', [broad::class, 'import'])->name('import');

