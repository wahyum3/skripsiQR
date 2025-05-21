<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barcode;

class QrCodeController extends Controller
{
    public function show(Request $request)
    {
        $data1 = $request->get('jenis_material', 'S20ff');
        $data2 = $request->get('quantity', '20');

        $combinedData = $data1 . ' qty' . $data2;

        return view('qr1', ['data' => $combinedData]);

    }
    public function store(Request $request)
    {
        $request->validate([
            'kode_qr' => 'required|string'
        ]);

        qrcodes::create(['kode_qr' => $request->kode_qr]);

        return response()->json(['message' => 'Barcode saved']);
    }
}
