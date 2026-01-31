@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold text-primary">Dashboard Admin</h2>
            <p class="text-muted">Selamat Datang kembali, <strong>{{ auth()->user()->nama }}</strong>. Apa yang ingin Anda kerjakan hari ini?</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white p-3">
                <div class="d-flex align-items-center">
                    <div class="display-5 me-3">📖</div>
                    <div>
                        <h6 class="mb-0">Koleksi Buku</h6>
                        <a href="/admin/buku" class="text-white-50 small text-decoration-none">Kelola Data →</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white p-3">
                <div class="d-flex align-items-center">
                    <div class="display-5 me-3">👥</div>
                    <div>
                        <h6 class="mb-0">Total Anggota</h6>
                        <a href="/admin/anggota" class="text-white-50 small text-decoration-none">Lihat Siswa →</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-warning text-white p-3">
                <div class="d-flex align-items-center">
                    <div class="display-5 me-3">📝</div>
                    <div>
                        <h6 class="mb-0">Transaksi Pinjam</h6>
                        <a href="/transaksi" class="text-white-50 small text-decoration-none">Cek Laporan →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Menu Navigasi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="/admin/buku" class="btn btn-outline-primary w-100 py-3 fw-bold">
                                📚 CRUD Data Buku
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="/admin/anggota" class="btn btn-outline-success w-100 py-3 fw-bold">
                                👥 Kelola Anggota
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="/transaksi" class="btn btn-outline-warning w-100 py-3 fw-bold">
                                📑 CRUD Transaksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection