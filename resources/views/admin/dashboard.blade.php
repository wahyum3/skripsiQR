<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Charts</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/logos/TTLC.jpg') }}" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('asset/css/styles.min.css') }}">
</head>
<body>

  @include('side.sideBarAdmin')
  <div class="camera-wrapper">
    <!-- Elemen untuk menyimpan data -->
    <div id="chartData"
        data-labels='@json($qrcodes->pluck("jenis_material"))'
        data-quantity-in='@json($qrcodes->pluck("quantity_in"))'
        data-quantity-out='@json($qrcodes->pluck("quantity_out"))'>
    </div>

    <!-- Chart Canvases -->
    <div class="chart-container">
      <h3>Bar Chart: Quantity In, Out, Tersisa</h3>
      <canvas id="barChart" width="400" height="200"></canvas>

      <h3>Pie Chart: Total Overview</h3>
      <canvas id="pieChart" width="400" height="200"></canvas>

      <h3>Bar Chart: Quantity Tersisa</h3>
      <canvas id="remainingBarChart" width="400" height="200"></canvas>
    </div>
  </div>

  <!-- Link to external JS -->
  <script src="{{ asset('asset/js/chart.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>