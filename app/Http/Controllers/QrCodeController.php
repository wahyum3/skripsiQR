<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\qrcodes;
use App\Models\Ros;

class QrCodeController extends Controller{

    // MENGATUR PEMBUATAN QR CODE
    public function show(Request $request)
    {
        $data1 = $request->get('jenis_material', 'A119FF');
        $data2 = $request->get('quantity', '20');

        $combinedData = $data1 . ' qty' . $data2;

        return view('qr1', ['data' => $combinedData]);

    }

    // MENGATUR INPUT DATA SCAN IN  //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_qr' => 'required|string',
            'jenis_material' => 'required|string',
            'quantity' => 'required|integer'
        ]);

        // Cek apakah kode_qr sudah ada
        $existing = qrcodes::where('kode_qr', $validated['kode_qr'])->first();

        if ($existing) {
            // Jika ada, tambahkan quantity dan update jenis_material jika perlu
            $existing->quantity_in += $validated['quantity'];
            $existing->jenis_material = $validated['jenis_material']; // optional: bisa dikunci
            $existing->save();

            return response()->json([
                'message' => 'Quantity updated',
                'data' => $existing
            ]);
        } else {
            // Jika tidak ada, buat entri baru
            $qrcode = qrcodes::create([
                'kode_qr' => $validated['kode_qr'],
                'jenis_material' => $validated['jenis_material'],
                'quantity_in' => $validated['quantity']
            ]);


        return response()->json([
            'message' => 'Barcode saved',
            'data' => $qrcode
        ]);
        }
    }

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

        return view('inboundList', compact('rosData', 'filterNoRo', 'sort'));
    }

    // MENGATUR TAMPILAN HALAMAN SORTIR DATA
    public function indexSortir(Request $request)
    {
        $sort = $request->get('sort', 'asc'); // default ke 'asc'

        $qrcodes = Qrcodes::with('ros')
        ->orderBy('jenis_material', in_array($sort, ['asc', 'desc']) ? $sort : 'asc')
        ->get();

        return view('sortirData', compact('qrcodes', 'sort'));
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

        return view('scan-out');
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

        return view('outboundList', compact('qrcodes'));
    }

    public function indexUpdate(Request $request)
    {
        $sort = $request->get('sort', 'asc');

        $qrcodes = Qrcodes::orderBy('jenis_material', in_array($sort, ['asc', 'desc']) ? $sort : 'asc')
                ->paginate(10);

        return view('listUpdate', compact('qrcodes', 'sort'));
    }


}
