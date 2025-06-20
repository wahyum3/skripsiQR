<?php


use App\Exports\IndexExport;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Models\qrcodes;
use App\Models\User;
use App\Exports\InboundExport;
use Maatwebsite\Excel\Facades\Excel;


///////////// AUTH LOGIN ///////////

Route::middleware('web')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
});



///////////////////// ROUTE PROSES SISTEM ////////////

/////////////// ROUTE USER ////////////
Route::middleware(['web', 'auth', 'user'])->group(function () {

    // INPUT DATA SCAN IN
    Route::get('/scan-in', function () {
        return view('layouts.scan_in');
    });


    // HALAMAN INBOUND LIST
    Route::get('/inbound', [QrCodeController::class, 'index'])->name('inboundList');
    Route::post('/inbound', [QrCodeController::class, 'index'])->name('inboundList');
    Route::get('/inbound/export', [QrCodeController::class, 'exportInbound'])->name('inbound.export');


    // HALAMAN SORTIR DATA
    Route::match(['get', 'post'], '/sortir-data', [QrCodeController::class, 'indexSortir'])->name('sortirData');
    Route::get('/sortir', [QrCodeController::class, 'indexSortir'])->name('sortir.data');
    Route::post('/sortir/submit', [QrCodeController::class, 'submit'])->name('sortir.submit');

    // SUBMIT SORTIR DATA
    Route::post('/sortir/submit', [QrCodeController::class, 'submit'])->name('sortir.submit');

    // SCAN OUT
    Route::get('/scan-out', function () {
        return view('layouts.scan_out');
    })->name('scanOut.form');
    Route::post('/scan-out', [QrCodeController::class, 'ScanOut'])->name('scanOut.submit');

    // HALAMAN OUTBOUND LIST
    Route::get('/outbound-list', [QrCodeController::class, 'indexOut'])->name('outboundList');

    // HALAMAN UPDATE LIST
    Route::get('/update-list', [QrCodeController::class, 'indexUpdate'])->name('updateList');
    Route::get('/dashboard', [QrCodeController::class, 'showChart'])->name('layouts.chartDiagram');
    Route::get('/stock-update/export', [QrCodeController::class, 'exportUpdate'])->name('stock.update.export');
});

Route::middleware(['web', 'auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'indexDashboard'])->name('admin.dashboard');
    Route::get('/admin/qr/show', [AdminDashboardController::class, 'indexQr'])->name('admin.qr.show');
    Route::get('/admin/qr/download', [AdminDashboardController::class, 'downloadQr'])->name('admin.qr.download');
    Route::get('/admin/Update-Material', [AdminDashboardController::class, 'indexUpdateM'])->name('admin.updateMaterial');
    Route::get('/stock-update/export', [AdminDashboardController::class, 'exportUpdate'])->name('stock.update.export');
});

// LOGOUT
Route::middleware(['web', 'auth'])->post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
