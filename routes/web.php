<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
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

Route::get('/pegawais', [PegawaiController::class, 'index']); // menampilkan keseluruhan data

Route::post('/pegawais/store', [PegawaiController::class,'store']); // menambahkan data
Route::get('/', [PegawaiController::class, 'createToken']); // membuat Token
Route::get('/pegawais/{id}', [PegawaiController::class, 'show']); // melihat data dengan id/ tidak keseluruhan

Route::patch('pegawais/{id}/update', [PegawaiController::class, 'update']); // update data

Route::delete('pegawais/{id}/delete', [PegawaiController::class, 'destroy']); // delete data
Route::get('pegawais/show/trash', [PegawaiController::class, 'trash']); // melihat data yang terhapus dan ada delected_id nya nanti
Route::get('pegawais/show/trash/{id}', [PegawaiController::class, 'restore']); // melihaat data yang terhapus dengan mencari (id) nya

Route::get('pegawais/show/permanent/{id}', [PegawaiController::class, 'permanentDelete']); // delete data secara permanent