<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Qrcode;
use App\Models\Ros;
use App\Exports\IndexExport;
use Maatwebsite\Excel\Facades\Excel;

class QrCodeController extends Controller
{
    // TAMPILKAN HALAMAN INBOUND LIST
    public function index(Request $request)
    {
        $rosData = Ros::with('qrcode')->get();

        return view('layouts.inboundList', compact('rosData'));
    }

    // EXPORT INBOUND KE EXCEL
    public function exportInbound()
    {
        $data = Ros::with('qrcode')->get()->map(function ($ros) {
            return [
                'No RO' => $ros->nomor_ro,
                'Kode QR' => $ros->qrcode->kode_qr ?? '-',
                'Jenis Material' => optional($ros->qrcode)->jenis_material ?? $ros->id_qrcode,
                'Quantity' => $ros->quantity,
                'Tanggal Masuk' => optional($ros->updated_at)->format('d-m-Y H:i:s') ?? '-',
            ];
        });

        $headings = ['No RO', 'Kode QR', 'Jenis Material', 'Quantity', 'Tanggal Masuk'];

        return Excel::download(new IndexExport($data, $headings), 'inbound_data_' . date('y-m-d') . '.xlsx');
    }

    // PROSES SCAN IN
    public function ScanIn(Request $request)
    {
        $request->validate([
            'kode_qr' => 'required|string',
        ]);

        // Pisah QR: contoh input = "A119FF qty20"
        $parts = explode(' qty', $request->kode_qr);

        if (count($parts) !== 2 || !is_numeric($parts[1])) {
            return response()->json(['message' => 'Format QR tidak valid.'], 400);
        }

        $kodeQr = trim($parts[0]);         // A119FF
        $quantity = (int) $parts[1];       // 20

        // Cari data berdasarkan kode_qr (bukan full string)
        $qrcode = Qrcode::where('kode_qr', $kodeQr)->first();

        if (!$qrcode) {
            return response()->json(['message' => 'QR Code tidak ditemukan.'], 404);
        }

        // Tambahkan quantity ke kolom quantity_in
        $qrcode->quantity_in = ($qrcode->quantity_in ?? 0) + $quantity;
        $qrcode->save();

        return response()->json(['message' => 'Quantity berhasil ditambahkan.']);
    }
    // HALAMAN SORTIR DATA
    public function indexSortir(Request $request)
    {
        $sort = $request->get('sort', 'asc');

        $qrcodes = Qrcode::with('ros')
            ->orderBy('jenis_material', in_array($sort, ['asc', 'desc']) ? $sort : 'asc')
            ->get();

        return view('layouts.sortirData', compact('qrcodes', 'sort'));
    }

    // SUBMIT SORTIR DATA
    public function submit(Request $request)
    {
        $selectedIds     = $request->input('selected', []);
        $inputQuantities = $request->input('input_quantity', []);
        $noSuratJalan    = $request->input('no_surat_jalan', []);

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Tidak ada item yang dipilih.');
        }

        DB::beginTransaction();

        try {
            foreach ($selectedIds as $id) {
                $qrcode = Qrcode::find($id);
                if (!$qrcode) continue;

                $qty     = (int) ($inputQuantities[$id] ?? 0);
                $noRO    = trim($noSuratJalan[$id] ?? '');

                if ($qty > 0 && $noRO !== '') {
                    $existing = Ros::where('id_qrcode', $qrcode->id)
                        ->where('nomor_ro', $noRO)
                        ->first();

                    if ($existing) {
                        $existing->quantity += $qty;
                        $existing->save();
                    } else {
                        Ros::create([
                            'id_qrcode' => $qrcode->id,
                            'nomor_ro'  => $noRO,
                            'quantity'  => $qty
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // PROSES SCAN OUT
    public function ScanOut(Request $request)
    {
        $request->validate([
            'kode_qr' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $qrcode = Qrcode::where('kode_qr', $request->kode_qr)->first();

        if (!$qrcode) {
            return response()->json(['message' => 'QR Code tidak ditemukan.'], 404);
        }

        // Hitung stok tersisa
        $tersisa = ($qrcode->quantity_in ?? 0) - ($qrcode->quantity_out ?? 0);

        // Jika stok tidak cukup
        if ($request->quantity > $tersisa) {
            return response()->json(['message' => 'Stock material ini habis atau tidak mencukupi.'], 400);
        }

        $qrcode->quantity_out = ($qrcode->quantity_out ?? 0) + $request->quantity;
        $qrcode->save();

        return response()->json(['message' => 'Quantity out berhasil disimpan.']);
    }

    // HALAMAN OUTBOUND LIST
    public function indexOut(Request $request)
    {

        $qrcodes = Qrcode::all();


        return view('layouts.outboundList', compact('qrcodes'));
    }

    // HALAMAN UPDATE MATERIAL
    public function indexUpdate(Request $request)
    {
       $qrcodes = Qrcode ::whereNotNull('quantity_in')
            ->orWhereNotNull('quantity_out')->get();

        return view('layouts.listUpdate', compact('qrcodes'));
    }

    // EXPORT DATA MATERIAL UPDATE
    public function exportUpdate()
    {
        $data = Qrcode::whereNotNull('quantity_in')
            ->orWhereNotNull('quantity_out')->get()->map(function ($item) {
            return [
                'Jenis Material' => $item->jenis_material,
                'Quantity In' => $item->quantity_in,
                'Quantity Out' => $item->quantity_out,
                'Quantity Tersisa' => $item->quantity_in - $item->quantity_out,
                'Tanggal Update' => optional($item->updated_at)->format('d-m-Y H:i:s') ?? '-',
            ];
        });

        $headings = ['Jenis Material', 'Quantity In', 'Quantity Out', 'Quantity Tersisa', 'Tanggal Update'];

        return Excel::download(new IndexExport($data, $headings), 'stock_update_' . date('y-m-d') . '.xlsx');
    }

    

    // CHART DASHBOARD
    public function showChart()
    {
        $qrcodes = Qrcode::whereNotNull('quantity_in')
            ->orWhereNotNull('quantity_out');
        return view('layouts.chartDiagram', compact('qrcodes'));
    }
}
