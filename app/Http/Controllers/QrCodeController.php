<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\qrcodes;
use App\Models\Ros;
use App\Models\User;
use App\Exports\IndexExport;
use Maatwebsite\Excel\Facades\Excel;

class QrCodeController extends Controller
{


    // MENGATUR HALAMAN INBOUND LIST
    public function index(Request $request)
    {
        $filterNoRo = $request->input('no_ro');
        $sort = strtolower($request->input('sort'));
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'asc';

        $rosData = Ros::with(['materialData' => function ($query) use ($sort) {
            $query->orderBy('jenis_material', $sort);
        }])
            ->when($filterNoRo, function ($query) use ($filterNoRo) {
                $query->where('nomor_ro', $filterNoRo);
            })
            ->paginate(10) // jumlah per halaman
            ->appends($request->query()); // menjaga query string seperti ?sort=asc

        return view('layouts.inboundList', compact('rosData', 'filterNoRo', 'sort'));
    }

    // MENGATUR DOWNLOAD DATA EXCEL INBOUND
    public function exportInbound()
    {
        $data = Ros::with('materialData')->get()->map(function ($ros) {
            return [
                'No RO' => $ros->nomor_ro,
                'Kode QR' => $ros->materialData->kode_qr ?? '-',
                'Jenis Material' => $ros->materialData->jenis_material ?? $ros->id_material,
                'Quantity' => $ros->quantity,
                'Tanggal Masuk' => optional($ros->updated_at)->format('d-m-Y H:i:s') ?? '-',
            ];
        });

        $headings = ['No RO', 'Kode QR', 'Jenis Material', 'Quantity', 'Tanggal Masuk'];

        return Excel::download(new IndexExport($data, $headings), 'inbound_data.xlsx');
    }

    // MENGATUR TAMPILAN HALAMAN SORTIR DATA
    public function indexSortir(Request $request)
    {
        $sort = $request->get('sort', 'asc'); // default ke 'asc'

        $qrcodes = Qrcodes::with('ros')
            ->orderBy('jenis_material', in_array($sort, ['asc', 'desc']) ? $sort : 'asc')
            ->get();

        return view('layouts.sortirData', compact('qrcodes', 'sort'));
    }


    // MENGATUR FUNGSI SUBMIT SORTIR DATA
    public function submit(Request $request)
    {
        $selectedIds = $request->input('selected', []);
        $inputQuantities = $request->input('input_quantity', []);
        $noSuratJalan = $request->input('no_surat_jalan', []);

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Tidak ada item yang dipilih.');
        }

        DB::beginTransaction();

        try {
            foreach ($selectedIds as $id) {
                $qrcode = qrcodes::find($id);
                if ($qrcode) {
                    $qty = $inputQuantities[$id] ?? 0;
                    $no_ro = $noSuratJalan[$id] ?? '';

                    // Validasi dasar
                    if ($qty > 0 && !empty($no_ro)) {
                        // Cek apakah sudah ada data dengan kombinasi ini
                        $existing = Ros::where('id_material', $qrcode->jenis_material)
                            ->where('nomor_ro', $no_ro)
                            ->first();

                        if ($existing) {
                            // Update quantity: tambah
                            $existing->quantity += $qty;
                            $existing->save();
                        } else {
                            // Buat entri baru
                            Ros::create([
                                'id_material' => $qrcode->jenis_material,
                                'nomor_ro' => $no_ro,
                                'quantity' => $qty
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan ke tabel ROS.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // MENGATUR HALAMAN SCAN OUT
    public function ScanOut(Request $request)
    {
        $request->validate([
            'kode_qr' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);

        $qrcode = Qrcodes::where('kode_qr', $request->kode_qr)->first();

        if (!$qrcode) {
            return response()->json(['message' => 'QR Code tidak ditemukan.'], 404);
        }

        // Tambahkan quantity_out, bukan timpa
        $qrcode->quantity_out = ($qrcode->quantity_out ?? 0) + $request->quantity;
        $qrcode->save();

        return response()->json(['message' => 'Quantity out berhasil disimpan.']);

        // return view('layouts.scan-out');
    }

    // MENGATUR HALAMAN OUTBOUND LIST
    public function indexOut(Request $request)
    {
        $query = qrcodes::query();

        // Sorting A-Z or Z-A berdasarkan jenis_material
        if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('jenis_material', $request->sort);
        } else {
            $query->orderBy('created_at', 'desc'); // default sorting
        }

        $qrcodes = $query->paginate(10);

        return view('layouts.outboundList', compact('qrcodes'));
    }

    // MENGATUR HALAMAN DATA UPDATE MATERIAL
    public function indexUpdate(Request $request)
    {
        $sort = $request->get('sort', 'asc');

        $qrcodes = Qrcodes::orderBy('jenis_material', in_array($sort, ['asc', 'desc']) ? $sort : 'asc')
            ->paginate(10);

        return view('layouts.listUpdate', compact('qrcodes', 'sort'));
    }

    // MENGATUR FUNGSI DOWNLOAD EXCEL DATA MATERIAL UPDATE
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

    // LOGIC DASHBOARD
    public function showChart(Request $request)
    {
        $qrcodes = Qrcodes::all(); // atau bisa filter sesuai kebutuhan
        return view('layouts.chartDiagram', compact('qrcodes'));
    }
}
