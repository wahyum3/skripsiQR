<!doctype html>
<html lang="en">

<head>
  <title>Stock Update</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/logos/TTLC.jpg') }}" />
  <link rel="stylesheet" href="{{ asset('asset/css/styles.min.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
</head>

<body>
  @include('side.sideBarAdmin')

  <div class="content-room">
    <!-- <div class="container mt-5"> -->
    <h2 class="mb-4">Daftar Material Update</h2>
    {{-- <div class="mb-4">
      <form action="{{ route('admin.updateMaterial') }}" method="GET" class="form-inline">
        <div class="form-group mr-2">
          <label for="stock_status" class="mr-2">Stock Status</label>
          <select name="stock_status" id="stock_status" class="form-control">
            <option value="">-- Semua --</option>
            <option value="empty" {{ request('stock_status') == 'empty' ? 'selected' : '' }}>Tidak ada Stock</option>
            <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.updateMaterial') }}" class="btn btn-secondary ml-2">Reset</a>
      </form>
    </div> --}}
    <a href="{{ route('stock.update.export') }}" class="btn btn-success">📥 Download Excel</a>
    <table class="table table-bordered" id="myTable">
      <thead class="thead-dark">
        <tr>
          <th>No</th>
          <th>Jenis Material</th>
          <th>Quantity In</th>
          <th>Quantity Out</th>
          <th>Quantity Tersisa</th>
          <th>Tanggal Update</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($qrcodes as $index => $item)
        <tr>
          <td data-label="No">{{ $index+1 }}</td>
          <td data-label="Jenis Material">{{ $item->jenis_material }}</td>
          <td data-label="Quantity In">{{ $item->quantity_in }}</td>
          <td data-label="Quantity Out">
            {{ is_null($item->quantity_out) ? 'Tidak ada data' : $item->quantity_out }}
          </td>
          <td data-label="Quantity Tersisa">
            @php
            $tersisa = $item->quantity_in - $item->quantity_out;
            @endphp
            {{ ($tersisa <= 0 || is_null($tersisa)) ? 'Tidak ada stock' : $tersisa }}
          </td>
          <td data-label="Tanggal Update">{{ $item->updated_at ? $item->updated_at->format('d-m-Y H:i:s') : '-' }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center">Tidak ada data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    {{-- <div class="d-flex justify-content-between">
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
    </div> --}}

    <!-- </div> -->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
  <script>
    let table = new DataTable('#myTable');
  </script>
</body>

</html>