<!doctype html>
<html lang="en">
  <head>
    <title>SORTIR DATA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('SideBar/css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container mt-5">
      <h2 class="mb-4">Daftar Data INBOUND Material</h2>
      <div class="mb-4">
        <form action="{{ route('sortirData') }}" method="GET" class="form-inline">
          <div class="form-group mr-2">
            <label for="sort" class="mr-2">Urutkan</label>
            <select name="sort" id="sort" class="form-control">
              <option value="">-- Pilih --</option>
              <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
              <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Filter</button>
          <a href="{{ route('sortirData') }}" class="btn btn-secondary ml-2">Reset</a>
        </form>
      </div>
      <form action="{{ route('sortir.submit') }}" method="POST">
        @csrf
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>Checklist</th>
              <th>No</th>
              <th>Kode QR</th>
              <th>Jenis Material</th>
              <th>Quantity</th>
              <th>Input Quantity</th>
              <th>No Surat Jalan</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($qrcodes as $index => $item)
              @php
                $usedQty = $item->ros->sum('quantity');
                $availableQty = $item->quantity_in - $usedQty;
              @endphp
              <tr>
                <td>
                  <input type="checkbox" name="selected[]" value="{{ $item->id }}">
                </td>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kode_qr }}</td>
                <td>{{ $item->jenis_material }}</td>
                <td>{{ $availableQty }}</td>
                <td>
                  <input type="number" name="input_quantity[{{ $item->id }}]" class="form-control" min="0" max="{{ $availableQty }}">
                </td>
                <td>
                  <input type="text" name="no_surat_jalan[{{ $item->id }}]" class="form-control">
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center">Tidak ada data QR code.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Submit Data</button>
        <a href="{{ route('inboundList') }}" class="btn btn-primary">Inbound List</a>
      </form>
    </div>

    <script src="{{ asset('SideBar/js/jquery.min.js') }}"></script>
    <script src="{{ asset('SideBar/js/popper.js') }}"></script>
    <script src="{{ asset('SideBar/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('SideBar/js/main.js') }}"></script>
  </body>
</html>

