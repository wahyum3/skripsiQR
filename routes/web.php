<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

///////////// ROUTE AUTH LOGIN /////////////

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';


///////////////////// ROUTE PROSES SISTEM ////////////

// HALAMAN UTAMA QR
Route::get('/generate-qr', [QrCodeController::class, 'show'])->name('qr1');
Route::post('/scan-in', [QrCodeController::class, 'store'])->name('scan-in');


// INPUT DATA SCAN IN
Route::get('/scan-in', function () {
    return view('scan_in');
});


// HALAMAN INBOUND LIST
Route::get('/inbound', [QrCodeController::class, 'index'])->name('inboundList');

// HALAMAN SORTIR DATA
Route::match(['get', 'post'], '/sortir-data', [QrCodeController::class, 'indexSortir'])->name('sortirData');
Route::get('/sortir', [QrCodeController::class, 'indexSortir'])->name('sortir.data');
Route::post('/sortir/submit', [QrCodeController::class, 'submit'])->name('sortir.submit');

// SUBMIT SORTIR DATA
Route::post('/sortir/submit', [QrCodeController::class, 'submit'])->name('sortir.submit');

// SCAN OUT
Route::get('/scan-out', function () {
    return view('scan_out');
})->name('scanOut.form');
Route::post('/scan-out', [QrCodeController::class, 'ScanOut'])->name('scanOut.submit');

// HALAMAN OUTBOUND LIST
Route::get('/outbound-list', [QrCodeController::class, 'indexOut'])->name('outboundList');

// HALAMAN UPDATE LIST
Route::get('/update-list', [QrCodeController::class, 'indexUpdate'])->name('updateList');
