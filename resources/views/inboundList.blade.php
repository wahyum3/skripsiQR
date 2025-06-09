<!doctype html>
<html lang="en">
  <head>
    <title>Data Material Inbound</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('SideBar/css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container mt-5">
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
      <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th>No RO</th>
            <th>Kode QR</th>
            <th>Jenis Material</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
        @forelse ($rosData as $ros)
          <tr>
            <td>{{ $ros->nomor_ro }}</td>
            <td>{{ $ros->materialData->kode_qr ?? '-' }}</td>
            <td>{{ $ros->materialData->jenis_material ?? $ros->id_material }}</td>
            <td>{{ $ros->quantity }}</td>
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

    <script src="{{ asset('SideBar/js/jquery.min.js') }}"></script>
    <script src="{{ asset('SideBar/js/popper.js') }}"></script>
    <script src="{{ asset('SideBar/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('SideBar/js/main.js') }}"></script>
  </body>
</html>
