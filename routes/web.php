<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'))->name('home');

//////////////////////////
// AUTHENTICATION ROUTES
//////////////////////////

Route::middleware('web')->group(function () {
    Route::get('/login', function () {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect('/admin/dashboard')
                : redirect('/dashboard');
        }

        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

//////////////////////////
// USER ROUTES
//////////////////////////
Route::middleware(['web', 'auth', 'user'])->group(function () {

    // SCAN IN
    Route::view('/scan-in', 'layouts.scan_in')->name('scanIn.form');
    Route::post('/scan-in', [QrCodeController::class, 'ScanIn'])->name('scanIn.submit');

    // INBOUND LIST
    Route::match(['get', 'post'], '/inbound', [QrCodeController::class, 'index'])->name('inboundList');
    Route::get('/inbound/export', [QrCodeController::class, 'exportInbound'])->name('inbound.export');

    // SORTIR DATA
    Route::match(['get', 'post'], '/sortir-data', [QrCodeController::class, 'indexSortir'])->name('sortirData');
    Route::post('/sortir/submit', [QrCodeController::class, 'submit'])->name('sortir.submit');

    // SCAN OUT
    Route::view('/scan-out', 'layouts.scan_out')->name('scanOut.form');
    Route::post('/scan-out', [QrCodeController::class, 'ScanOut'])->name('scanOut.submit');

    // OUTBOUND LIST
    Route::get('/outbound-list', [QrCodeController::class, 'indexOut'])->name('outboundList');

    // STOCK UPDATE
    Route::get('/update-list', [QrCodeController::class, 'indexUpdate'])->name('updateList');
    Route::get('/stock-update/export', [QrCodeController::class, 'exportUpdate'])->name('stock.update.export');

    // DASHBOARD
    Route::get('/dashboard', [QrCodeController::class, 'showChart'])->name('layouts.chartDiagram');
});

//////////////////////////
// ADMIN ROUTES
//////////////////////////
Route::middleware(['web', 'auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'indexDashboard'])->name('admin.dashboard');

    // QR Management
    Route::get('/admin/qr', [AdminDashboardController::class, 'formQr'])->name('admin.qr.form'); // Tampilkan form
    Route::post('/admin/qr/show', [AdminDashboardController::class, 'indexQr'])->name('admin.qr.show'); // Proses generate QR
    Route::post('/admin/qr/download', [AdminDashboardController::class, 'downloadQr'])->name('admin.qr.download'); // Download QR

    // Material Update
    Route::get('/admin/Update-Material', [AdminDashboardController::class, 'indexUpdateM'])->name('admin.updateMaterial');
    Route::get('/stock-update/export', [AdminDashboardController::class, 'exportUpdate'])->name('stock.update.export');

    // User Control
    Route::get('/admin/user', [AdminDashboardController::class, 'indexUser'])->name('admin.userControl');
    Route::post('/admin/user/store', [AdminDashboardController::class, 'storeUser'])->name('admin.userControl.store');
    Route::put('/admin/user/update-password/{id}', [AdminDashboardController::class, 'updatePw'])->name('admin.userControl.updatePassword');
    Route::delete('/admin/user/{id}', [AdminDashboardController::class, 'deleteUser'])->name('admin.userControl.delete');
});

//////////////////////////
// LOGOUT ROUTE
//////////////////////////
Route::middleware(['web', 'auth'])->post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
