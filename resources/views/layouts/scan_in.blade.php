<!doctype html>
<html lang="en">
<head>
  <title>Scanner</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" type="image/png" href="./asset/images/logos/TTLC.jpg" />
  <link rel="stylesheet" href="./asset/css/styles.min.css" />
</head>
<body>
    @include('side.sideBar')

  <div class="camera-wrapper">
    <div id="reader"></div>
    <p id="scan-result" class="mt-3"></p>

    <h2 class="mt-4">SCAN IN</h2>
    <a href="{{ route('sortirData') }}" class="btn btn-primary">List Scan</a>
  </div>

      

  <!-- </div> -->

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="{{ asset('asset/js/camin.js') }}"></script>
</body>
</html>