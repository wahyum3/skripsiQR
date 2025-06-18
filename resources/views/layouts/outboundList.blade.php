<!doctype html>
<html lang="en">

<head>
  <title>Outbound List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" type="image/png" href="./asset/images/logos/TTLC.jpg">
  <link rel="stylesheet" href="./asset/css/styles.min.css">
</head>

<body>

 @include('side.sideBar')

  <div class="content-room">
    <h2 class="mb-4">Daftar Data OUTBOUND Material</h2>
    <div class="mb-4">
      <form action="{{ route('outboundList') }}" method="GET" class="form-inline">
        <div class="form-group mr-2">
          <label for="sort" class="mr-2">Urutkan</label>
          <select name="sort" id="sort" class="form-control">
            <option value="">-- Pilih --</option>
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('outboundList') }}" class="btn btn-secondary ml-2">Reset</a>
      </form>
    </div>
    <table class="table table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>No</th>
          <th>Kode QR</th>
          <th>Jenis Material</th>
          <th>Quantity</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($qrcodes as $qr)
        <tr>
          <td>{{ ($qrcodes->currentPage() - 1) * $qrcodes->perPage() + $loop->iteration }}</td>
          <td>{{ $qr->kode_qr }}</td>
          <td>{{ $qr->jenis_material }}</td>
          <td>{{ $qr->quantity_out > 0 ? $qr->quantity_out : 'No Scanned' }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3" class="text-center">Tidak ada data QR Code.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <div class="d-flex justify-content-between">
      @if ($qrcodes->onFirstPage())
      <span class="btn btn-secondary disabled">← Previous</span>
      @else
      <a href="{{ $qrcodes->previousPageUrl() }}" class="btn btn-primary">← Previous</a>
      @endif

      @if ($qrcodes->hasMorePages())
      <a href="{{ $qrcodes->nextPageUrl() }}" class="btn btn-primary">Next →</a>
      @else
      <span class="btn btn-secondary disabled">Next →</span>
      @endif
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>