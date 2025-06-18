<!DOCTYPE html>
<html lang="en">
<head>
  <title>QR Generator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" type="image/png" href="./asset/images/logos/TTLC.jpg" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./asset/css/styles.min.css" />
</head>

<body>
    @include('side.sideBar')
    <div class="camera-wrapper">
        <div style="text-align: center; margin-top: 50px;">
            <h2>QR Code Generator</h2>
            <p>Data: {{ $data }}</p>

            {!! QrCode::size(200)->generate($data) !!} <!-- Menampilkan QR Code -->

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
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>