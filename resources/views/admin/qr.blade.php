<!DOCTYPE html>
<html lang="en">

<head>
  <title>QR Generator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/logos/TTLC.jpg') }}" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('asset/css/styles.min.css') }}">
</head>

<body>
  @include('side.sideBarAdmin')

  <div class="content-room">
    <div class="camera-wrapper">
      <div style="text-align: center; margin-top: 50px;">
        <h2>QR Code Generator</h2>
        <form method="POST" action="{{ route('admin.qr.show') }}">
          @csrf
          <label>Jenis Material:</label>
          <input type="text" name="jenis_material" value="{{ old('jenis_material', $data1 ?? '') }}" placeholder="Masukkan jenis material" />

          <label>Quantity:</label>
          <input type="number" name="quantity" value="{{ old('quantity', $data2 ?? '') }}" placeholder="Masukkan quantity" />

          <button class="btn btn-primary" type="submit">Generate QR Code</button>
        </form>

        @if ($errors->any())
        <div class="alert alert-danger mt-2" style="max-width: 300px; margin: auto;">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        @if(isset($qrCode) && $qrCode)
        <h3>Hasil:</h3>
        <p>{{ $data1 }} qty{{ $data2 }}</p>

        <div>{!! $qrCode !!}</div>

        <br />

        <form class="center" method="POST" action="{{ route('admin.qr.download') }}">
          @csrf
          <input type="hidden" name="jenis_material" value="{{ $data1 }}">
          <input type="hidden" name="quantity" value="{{ $data2 }}">
          <button class="d-flex btn btn-primary">Download QR Code</button>
        </form>
        @endif

        <br><br>


      </div>
    </div>

  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="{{ asset('asset/js/alertQr.js') }}"></script>

</body>

</html>