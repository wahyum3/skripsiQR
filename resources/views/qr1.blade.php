<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code Generator</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h2>QR Code Generator</h2>
        <p>Data: {{ $data }}</p>
        
        {!! QrCode::size(200)->generate($data) !!}
        
    </div>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Code Generator</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h2>QR Code Generator</h2>
        <p>Data: {{ $data }}</p>
        
        {!! QrCode::size(200)->generate($data) !!}  <!-- Menampilkan QR Code -->

        <form action="{{ route('scan-in') }}" method="POST">
            @csrf
            <!-- <input type="text" name="kode_qr" value="{{ $data }}" hidden> Data QR Code -->
             <!-- {{-- Ambil data dari string gabungan --}} -->
            <?php
                // Pisahkan data: misalnya "S50FF qty20"
                $parts = explode(' qty', $data);
                $jenis_material = $parts[0] ?? '';
                $quantity_in = $parts[1] ?? 0;
            ?>

            {{-- Hidden input untuk simpan data ke database --}}
            <input type="hidden" name="kode_qr" value="{{ $jenis_material }}"> <!-- hanya 'S50FF' -->
            <input type="hidden" name="jenis_material" value="{{ $jenis_material }}">
            <input type="hidden" name="quantity" value="{{ $quantity_in }}">
            <button type="submit">Simpan Data QR ke Database</button>
        </form>
    </div>
</body>
</html>
