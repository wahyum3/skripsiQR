<!doctype html>
<html lang="en">

<head>
  <title>Outbound List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" type="image/png" href="./asset/images/logos/TTLC.jpg">
  <link rel="stylesheet" href="./asset/css/styles.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
</head>

<body>

 @include('side.sideBar')

  <div class="content-room">
    <h2 class="mb-4">Daftar Data OUTBOUND Material</h2>
    <table class="table table-bordered" id="myTable">
      <thead class="thead-dark">
        <tr>
          <th>No</th>
          <th>Kode QR</th>
          <th>Jenis Material</th>
          <th>Quantity</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($qrcodes as $index => $item)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $item->kode_qr }}</td>
          <td>{{ $item->jenis_material }}</td>
          <td>{{ $item->quantity_out > 0 ? $item->quantity_out : 'No Scanned' }}</td>
        </tr>
        @endforeach
        @if($qrcodes->isEmpty())
        <tr>
          <td colspan="4" class="text-center">Tidak ada data QR Code.</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
  <script>
    let table = new DataTable('#myTable');
  </script>
</body>

</html>