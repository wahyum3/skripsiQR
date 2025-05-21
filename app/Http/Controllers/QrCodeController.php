<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\qrcodes;

class QrCodeController extends Controller
{
    public function show(Request $request)
    {
        $data1 = $request->get('jenis_material', 'S50FF');
        $data2 = $request->get('quantity', '20');

        $combinedData = $data1 . ' qty' . $data2;

        return view('qr1', ['data' => $combinedData]);

    }
    public function store(Request $request)
    {
    $validated = $request->validate([
        'kode_qr' => 'required|string'
    ]);

    // Simpan data ke tabel qrcodes
    $qrcodes = qrcodes::create([
        'kode_qr' => $validated['kode_qr']
    ]);

    return response()->json([
        'message' => 'Barcode saved',
        'data' => $qrcodes
    ]);
    }

}
