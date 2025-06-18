<!DOCTYPE html>
<html lang="en">

<head>
  <title>QR Generator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" type="image/png" href="./asset/images/logos/TTLC.jpg" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('asset/css/styles.min.css') }}">
</head>

<body>
  @include('side.sideBarAdmin')
  <div class="camera-wrapper">
    <div style="text-align: center; margin-top: 50px;">
      <h2>QR Code Generator</h2>
      <form method="GET" action="{{ route('admin.qr.show') }}"></form>
        <label>Jenis Material:</label>
        <input type="text" name="jenis_material" value="{{ $data1 }}">
        <br>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="{{ $data2 }}">
        <br><br>

        <button type="submit">Generate QR Code</button>
      </form>

      <h3>Hasil:</h3>
      <p>{{ $data1 }} qty{{ $data2 }}</p>

      {!! $qrCode !!} <!-- QR Code ditampilkan -->

      <br><br>

      <!-- Tombol Download -->
      <form method="GET" action="{{ route('admin.qr.download') }}"></form>
        <input type="hidden" name="jenis_material" value="{{ $data1 }}">
        <input type="hidden" name="quantity" value="{{ $data2 }}">
        <button type="submit">Download QR Code</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>