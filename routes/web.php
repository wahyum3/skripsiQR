<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/home', function () {
    return view('home');
});
Route::get('/scan-in', function () {
    return view('scan_in');
})->name('scan-in');

Route::get('/inbound-list', function () {
    return view('inboundList');
})->name('inbound-list');

Route::get('/scan-out', function () {
    return view('scan_out');
})->name('scan-out');

Route::get('/outbound-list', function () {
    return view('outboundList');
})->name('outbound-list');

Route::get('/generate-qr', [QrCodeController::class, 'show'])->name('generate-qr');
Route::post('/scan-in', [QrCodeController::class, 'store']);
