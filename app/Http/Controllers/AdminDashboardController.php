<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\qrcodes;
use App\Models\Ros;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class AdminDashboardController extends Controller
{
    // public function indexDashboard(Request $request)
    // {
    //     $qrcodes = Qrcodes::all(); // atau bisa filter sesuai kebutuhan
    //     return view('admin.dashboard', compact('qrcodes'));
    // }

    public function indexQr(Request $request)
    {
        $data1 = $request->get('jenis_material', 'A119FF');
        $data2 = $request->get('quantity', '20');

        $combinedData = $data1 . ' qty' . $data2;

        // Generate QR code as base64
        $qrCode = QrCode::size(200)->generate($combinedData);

        return view('admin.qr1', [
            'data1' => $data1,
            'data2' => $data2,
            'qrCode' => $qrCode
        ]);
    }

    public function downloadQr(Request $request)
    {
        $data1 = $request->get('jenis_material', 'A119FF');
        $data2 = $request->get('quantity', '20');
        $combinedData = $data1 . ' qty' . $data2;

        // Generate QR code image in PNG
        $image = QrCode::format('png')->size(300)->generate($combinedData);

        $filename = 'qr_' . $data1 . '_' . $data2 . '.png';

        return response($image)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
