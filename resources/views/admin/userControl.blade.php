<!doctype html>
<html lang="en">

<head>
    <title>Daftar Pengguna</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/logos/TTLC.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/styles.min.css') }}">
</head>

<body>
    @include('side.sideBarAdmin')

    <div class="content-room">
        <h2 class="mb-4">Daftar Pengguna</h2>

        {{-- Form Tambah User --}}
        <div class="mb-4">
            <form action="{{ route('admin.userControl.store') }}" method="POST" class="form-inline">
                @csrf
                <div class="form-group mr-2">
                    <input type="text" name="id_pegawai" class="form-control" placeholder="NIK (ID Pegawai)" required>
                </div>
                <div class="form-group mr-2">
                    <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                </div>
                <div class="form-group mr-2">
                    <select name="role" class="form-control" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">➕ Tambah User</button>
            </form>
        </div>

        {{-- Tabel User --}}
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>ID Pegawai (NIK)</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                <tr>
                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                    <td>{{ $user->id_pegawai }}</td>
                    <td>{{ $user->nama }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->created_at->format('d-m-Y H:i:s') }}</td>
                    <td class="d-flex gap-1">
                        {{-- Tombol Ubah Password --}}
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ubahPasswordModal{{ $user->id }}">
                            🔑 Ubah Password
                        </button>

                        {{-- Form Hapus --}}
                        <form action="{{ route('admin.userControl.delete', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">🗑 Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{-- Semua modal diletakkan DI LUAR tabel --}}
        @foreach ($users as $user)
        <div class="modal fade" id="ubahPasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="ubahPasswordModalLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.userControl.updatePassword', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ubah Password - {{ $user->nama }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-2">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control" required minlength="6">
                            </div>
                            <div class="form-group mb-2">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-between">
            {{ $users->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>