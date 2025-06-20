<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\qrcodes;
use App\Models\Ros;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Exports\IndexExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminDashboardController extends Controller
{
    public function indexDashboard(Request $request)
    {
        $qrcodes = Qrcodes::all(); // atau bisa filter sesuai kebutuhan
        return view('admin.dashboard', compact('qrcodes'));
    }

    public function indexUpdateM(Request $request)
    {
        $sort = $request->get('sort', 'asc');

        $qrcodes = Qrcodes::orderBy('jenis_material', in_array($sort, ['asc', 'desc']) ? $sort : 'asc')
            ->paginate(10);

        return view('admin.updateMaterial', compact('qrcodes', 'sort'));
    }

    public function exportUpdate()
    {
        $data = qrcodes::all()->map(function ($item) {
            return [
                'Jenis Material' => $item->jenis_material,
                'Quantity In' => $item->quantity_in,
                'Quantity Out' => $item->quantity_out,
                'Quantity Tersisa' => $item->quantity_in - $item->quantity_out,
                'Tanggal Update' => optional($item->updated_at)->format('d-m-Y H:i:s') ?? '-',
            ];
        });

        $headings = ['Jenis Material', 'Quantity In', 'Quantity Out', 'Quantity Tersisa', 'Tanggal Update'];

        return Excel::download(new IndexExport($data, $headings), 'stock_update.xlsx');
    }

    public function indexQr(Request $request)
    {
        $data1 = $request->get('jenis_material', 'A119FF');
        $data2 = $request->get('quantity', '20');

        $combinedData = $data1 . ' qty' . $data2;

        // Generate QR code as base64
        $qrCode = QrCode::size(200)->generate($combinedData);

        return view('admin.qr', [
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

        // Generate PNG menggunakan Endroid
        $qrCode = new EndroidQrCode($combinedData);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $filename = 'qr_' . $data1 . '_' . $data2 . '.png';

        return response($result->getString())
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
