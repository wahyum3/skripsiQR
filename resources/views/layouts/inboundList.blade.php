<!doctype html>
<html lang="en">

<head>
  <title>Inbound List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" type="image/png" href="./asset/images/logos/TTLC.jpg">
  <link rel="stylesheet" href="./asset/css/styles.min.css">
</head>

<body>

 @include('side.sideBar')

  <div class="content-room">
    <h2 class="mb-4">Daftar Data INBOUND Material</h2>
    <div class="mb-4">
      <form action="{{ route('inboundList') }}" method="GET" class="form-inline">
        <div class="form-group mr-2">
          <label for="no_ro" class="mr-2">Filter No RO</label>
          <input type="text" name="no_ro" id="no_ro" value="{{ request('no_ro') }}" class="form-control">
        </div>

        <div class="form-group mr-2">
          <label for="sort" class="mr-2">Urutkan</label>
          <select name="sort" id="sort" class="form-control">
            <option value="">-- Pilih --</option>
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('inboundList') }}" class="btn btn-secondary ml-2">Reset</a>
      </form>
    </div>
    <a href="{{ route('inbound.export') }}" class="btn btn-success">📥 Download Excel</a>
    <table class="table table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>No RO</th>
          <th>Kode QR</th>
          <th>Jenis Material</th>
          <th>Quantity</th>
          <th>Tanggal Masuk</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($rosData as $ros)
        <tr>
          <td>{{ $ros->nomor_ro }}</td>
          <td>{{ $ros->qrcode->kode_qr ?? '-' }}</td>
          <td>{{ $ros->qrcode->jenis_material ?? $ros->id_material }}</td>
          <td>{{ $ros->quantity }}</td>
          <td>{{ $ros->updated_at ? $ros->updated_at->format('d-m-Y H:i:s') : '-' }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="text-center">Tidak ada data RO.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <div class="d-flex justify-content-between">
      @if ($rosData->onFirstPage())
      <span class="btn btn-secondary disabled">← Previous</span>
      @else
      <a href="{{ $rosData->previousPageUrl() }}" class="btn btn-primary">← Previous</a>
      @endif

      @if ($rosData->hasMorePages())
      <a href="{{ $rosData->nextPageUrl() }}" class="btn btn-primary">Next →</a>
      @else
      <span class="btn btn-secondary disabled">Next →</span>
      @endif
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>