<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Qrcode;
use App\Models\Ros;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IndexExport;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeFacade;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter;

class AdminDashboardController extends Controller
{
    public function indexDashboard(Request $request)
    {
        $qrcodes = Qrcode::all();
        return view('admin.dashboard', compact('qrcodes'));
    }

    public function indexUpdateM(Request $request)
    {
        $sort = $request->get('sort', 'asc');

        $qrcodes = Qrcode::orderBy('jenis_material', in_array($sort, ['asc', 'desc']) ? $sort : 'asc')
            ->paginate(10);

        return view('admin.updateMaterial', compact('qrcodes', 'sort'));
    }

    public function exportUpdate()
    {
        $data = Qrcode::all()->map(function ($item) {
            return [
                'Jenis Material'    => $item->jenis_material,
                'Quantity In'       => $item->quantity_in,
                'Quantity Out'      => $item->quantity_out,
                'Quantity Tersisa'  => ($item->quantity_in - $item->quantity_out),
                'Tanggal Update'    => optional($item->updated_at)->format('d-m-Y H:i:s') ?? '-',
            ];
        });

        $headings = ['Jenis Material', 'Quantity In', 'Quantity Out', 'Quantity Tersisa', 'Tanggal Update'];

        return Excel::download(new IndexExport($data, $headings), 'stock_update_' . date('Y-m-d') . '.xlsx');
    }

    private $defaultJenisMaterial = 'A119FF';
    private $defaultQuantity = 20;

    // Tampilkan form kosong
    public function formQr()
    {
        return view('admin.qr', [
            'data1' => old('jenis_material', ''),
            'data2' => old('quantity', ''),
            'qrCode' => null,
        ]);
    }


    public function indexQr(Request $request)
    {
        $validated = $request->validate([
            'jenis_material' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
        ]);

        $jenisMaterial = trim($validated['jenis_material']);
        $quantity = $validated['quantity'];
        $kodeQr = $jenisMaterial; // Kode yang disimpan di DB
        $qrContent = $kodeQr . ' qty' . $quantity; // Isi QR yang dibaca scanner

        // Simpan data jika belum ada
        Qrcode::firstOrCreate(
            ['kode_qr' => $kodeQr],
            [
                'jenis_material' => $jenisMaterial,
                'status_at' => now(),
            ]
        );

        // Generate QR code
        $qrCode = QrCodeFacade::size(200)->generate($qrContent);

        return view('admin.qr', [
            'data1' => $jenisMaterial,
            'data2' => $quantity,
            'qrCode' => $qrCode,
        ]);
    }

    public function downloadQr(Request $request)
    {
        $validated = $request->validate([
            'jenis_material' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
        ]);

        $jenisMaterial = trim($validated['jenis_material']);
        $quantity = $validated['quantity'];
        $combinedData = $jenisMaterial . ' qty' . $quantity;

        // Hanya generate file, tidak simpan ke database
        $qrCode = new EndroidQrCode($combinedData);
        $qrCode->setSize(300)->setMargin(10);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $filename = 'qr_' . $jenisMaterial . '_' . $quantity . '.png';

        return response($result->getString())
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function indexUser()
    {
        $users = User::latest()->paginate(10);
        return view('admin.userControl', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|string|unique:users,id_pegawai',
            'nama'       => 'required|string|max:255',
            'role'       => 'required|in:user,admin',
        ]);

        User::create([
            'id_pegawai' => $request->id_pegawai,
            'nama'       => $request->nama,
            'role'       => $request->role,
            'password'   => bcrypt('password') // Default password
        ]);

        return redirect()->route('admin.userControl')
            ->with('success', 'User berhasil ditambahkan. Password default: "password"');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.userControl')->with('success', 'User berhasil dihapus.');
    }

    public function updatePw(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }
}
