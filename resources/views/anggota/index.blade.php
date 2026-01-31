@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Tambah User/Admin</h5>
                </div>
                <div class="card-body">
                    <form action="/admin/anggota/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Role Akses</label>
                            <select name="role" id="role_select" class="form-select" onchange="toggleSiswa()" required>
                                <option value="siswa">Siswa (Anggota)</option>
                                <option value="admin">Admin (Petugas)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div id="siswa_fields">
                            <hr>
                            <div class="mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Kelas</label>
                                    <select name="kelas" class="form-select">
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <select name="jurusan" class="form-select">
                                        <option value="RPL">RPL</option>
                                        <option value="TKJ">TKJ</option>
                                        <option value="MM">MM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. Telp</label>
                                <input type="text" name="no_telp" class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold">SIMPAN DATA</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">Daftar Pengguna</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Nama / User</th>
                                    <th>Role</th>
                                    <th>Info</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $u)
                                <tr>
                                    <td class="ps-3">
                                        <strong>{{ $u->nama }}</strong><br>
                                        <small class="text-muted">@ {{ $u->username }}</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $u->role == 'admin' ? 'bg-danger' : 'bg-info' }}">
                                            {{ strtoupper($u->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($u->role == 'siswa')
                                            <small>{{ $u->nis }} ({{ $u->kelas }}-{{ $u->jurusan }})</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/anggota/delete/{{ $u->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">Hapus</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSiswa() {
        var role = document.getElementById('role_select').value;
        var fields = document.getElementById('siswa_fields');
        fields.style.display = (role === 'admin') ? 'none' : 'block';
    }
    // Jalankan sekali saat load agar posisi benar
    toggleSiswa();
</script>
@endsection