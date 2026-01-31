@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary text-white p-3 rounded-circle me-3 shadow-sm">
            <i class="fas fa-book-reader fa-lg"></i>
        </div>
        <div>
            <h4 class="fw-bold mb-0 text-dark">Layanan Perpustakaan</h4>
            <p class="text-muted mb-0 small">Pinjam buku dan pantau status pengembalian Anda.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-4"><i class="fas fa-plus-circle text-primary me-2"></i>Pinjam Buku Baru</h6>
                    <form action="/transaksi/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Daftar Buku Tersedia</label>
                            <select name="id_buku" class="form-select border-0 bg-light rounded-3 py-2" required>
                                <option value="" disabled selected>-- Cari & Pilih Buku --</option>
                                @foreach($bukus as $b)
                                    <option value="{{ $b->id_buku }}">{{ $b->nama_buku }} (Stok: {{ $b->stok }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="bg-light p-3 rounded-3 mb-4">
                            <p class="small text-muted mb-0"><i class="fas fa-info-circle me-1"></i> Durasi pinjam maksimal adalah <strong>7 hari</strong>. Keterlambatan dikenakan denda Rp 1.000/hari.</p>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3 shadow-sm">
                            Pinjam Sekarang <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0"><i class="fas fa-history text-primary me-2"></i>Riwayat Pinjaman Saya</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-muted text-uppercase">
                                <th class="ps-4">Informasi Buku</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Denda</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $t)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark">{{ $t->nama_buku }}</div>
                                        <div class="text-muted small">ID Trs: #{{ $t->id_transaksi }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($t->status == 'Pinjam')
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-normal">Sedang Dipinjam</span>
                                        @else
                                            <span class="badge bg-success rounded-pill px-3 py-2 fw-normal">Telah Kembali</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($t->total_denda > 0)
                                            <div class="text-danger fw-bold small">Rp {{ number_format($t->total_denda) }}</div>
                                            <div class="text-muted" style="font-size: 10px;">Terlambat</div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm rounded-3">
                                            <a href="/transaksi/edit/{{ $t->id_transaksi }}" class="btn btn-white btn-sm text-warning" title="Edit Pinjaman">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/transaksi/delete/{{ $t->id_transaksi }}" class="btn btn-white btn-sm text-danger" title="Hapus Riwayat" onclick="return confirm('Hapus riwayat ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <img src="https://illustrations.popsy.co/gray/reading-book.svg" alt="no-data" style="width: 120px;" class="mb-3 d-block mx-auto">
                                        Belum ada riwayat peminjaman buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection