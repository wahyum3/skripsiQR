<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\IsAdmin;
use App\Models\qrcodes;
use App\Models\User;






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
require __DIR__ . '/auth.php';


///////////////////// ROUTE PROSES SISTEM ////////////

// HALAMAN UTAMA QR
Route::get('/generate-qr', [QrCodeController::class, 'show'])->name('layouts.qr1');
Route::post('/scan-in', [QrCodeController::class, 'store'])->name('scan-in');


// INPUT DATA SCAN IN
Route::get('/scan-in', function () {
    return view('layouts.scan_in');
});


// HALAMAN INBOUND LIST
Route::get('/inbound', [QrCodeController::class, 'index'])->name('inboundList');
Route::post('/inbound', [QrCodeController::class, 'index'])->name('inboundList');

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

Route::get('/dashboard', function () {
    return view('layouts.chartDiagram');
});
Route::get('/dashboard', [QrCodeController::class, 'showChart']);



Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('layouts.chartDiagram');
    })->name('layouts.chartDiagram');
});


Route::middleware(['web','auth','admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'indexDashboard'])->name('admin.dashboard');
    Route::get('/admin/qr/show', [AdminDashboardController::class, 'indexQr'])->name('admin.qr.show');
    Route::get('/admin/qr/download', [AdminDashboardController::class, 'downloadQr'])->name('admin.qr.download');
});




// Route::middleware(['web', 'auth', 'admin'])->group(function () {

//     Route::get('/admin/dashboard', function () {
//         $qrcodes = qrcodes::all();
//         return view('admin.dashboard', compact('qrcodes'));
//     })->name('admin.dashboard');

//     // Route show QR Generator
//     Route::get('/admin/qr/show', [AdminDashboardController::class, 'indexQr'])->name('admin.qr.show');

//     // // Route download QR code
//     Route::get('/admin/qr/download', [AdminDashboardController::class, 'downloadQr'])->name('admin.qr.download');
// });



Route::middleware('web')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.custom');
});

// Route::get('/check-user', function () {
//     if (auth()->check()) {
//         return 'Login sebagai: ' . auth()->user()->email . ' | Role: ' . auth()->user()->role;
//     } else {
//         return 'Belum login';
//     }
// })->middleware('web'); // ✅ Tambahkan ini!

// Route::get('/test-session', function (\Illuminate\Http\Request $request) {
//     return $request->session()->all();
// })->middleware('web');
