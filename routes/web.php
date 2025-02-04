<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Monitor; // Pastikan class controller di-import dengan benar
use App\Http\Controllers\broad; // Pastikan class controller di-import dengan benar
use App\Http\Controllers\Reseller; // Pastikan class controller di-import dengan benar
use App\Http\Controllers\CrudResellerMongo; // Pastikan class controller di-import dengan benar
use App\Http\Controllers\Traffic; // Pastikan class controller di-import dengan benar


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


//Voucher Usage-------------------------------------------------------------------------------------///
Route::get('/', [Monitor::class, 'index'])->name('monitor');
Route::get('voucher_detail.{id}.{tgl1}.{tgl2}.{status}', [Monitor::class, 'show'])->name('voucher_detail');

//Broadcast-------------------------------------------------------------------------------------///

//Database
Route::get('/broad', [broad::class, 'index'])->name('broad');
Route::post('/post-data', [broad::class, 'postData'])->name('post');  // Untuk mengirim data ke API
Route::post('/kirim-nama/{awal}.{akhir}', [broad::class, 'kirimData'])->name('kirim');  // Untuk mengirim data ke API
Route::post('/kirimself/{pengirim}', [broad::class, 'selfKirim'])->name('selfKirim');  // Untuk mengirim data ke API

//Data CSV
Route::get('/showfile', [broad::class, 'showfile'])->name('showfile');
Route::post('/fileManual/{pengirim}', [broad::class, 'fileManual'])->name('fileManual');
Route::post('/fileKirim', [broad::class, 'fileKirim'])->name('fileKirim');
Route::post('/import', [broad::class, 'import'])->name('import');
Route::post('/tempes', [broad::class, 'tempes'])->name('tempes');
// Route::get('/template_pesan', function () {
//     $tempes = Storage::disk('public')->get('tempes.txt');
//     return "<h1>{$tempes}</h1>"; // Mengembalikan teks sebagai HTML
// });
Route::get('/Pesan', [broad::class, 'Pesan'])->name('Pesan');
Route::post('/addPesan', [broad::class, 'addPesan'])->name('addPesan');
Route::put('/editPesan{id}', [broad::class, 'editPesan'])->name('editPesan');
Route::put('/aktivasiPesan{id}', [broad::class, 'aktivasiPesan'])->name('aktivasiPesan');

Route::delete('/deletePesan{id}', [broad::class, 'deletePesan'])->name('deletePesan');






//Reseller-------------------------------------------------------------------------------------///
Route::get('/Reseller', [Reseller::class, 'index'])->name('Reseller');

Route::get('export-reseller-csv', [Reseller::class, 'exportResellerData'])->name('export.reseller.csv');


// Crud ResellerMongo

Route::get('/ResellerMongo', [CrudResellerMongo::class, 'index'])->name('ResellerMongo');
Route::put('/editResellerMongo{id}', [CrudResellerMongo::class, 'edit'])->name('editResellerMongo');


//Traffic
Route::get('/traffic', [Traffic::class, 'index'])->name('dashboard');
Route::get('grafik', [Traffic::class, 'grafik'])->name('grafik');