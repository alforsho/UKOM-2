@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white fw-bold">Monitoring Transaksi (Admin)</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Peminjam</th><th>Buku</th><th>Status</th><th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $t)
                    <tr>
                        <td class="ps-3">{{ $t->nama }}</td>
                        <td>{{ $t->nama_buku }}</td>
                        <td><span class="badge {{ $t->status == 'Pinjam' ? 'bg-warning' : 'bg-success' }}">{{ $t->status }}</span></td>
                        <td class="text-center">
                            @if($t->status == 'Pinjam')
                                <a href="/transaksi/kembali/{{ $t->id_transaksi }}" class="btn btn-success btn-sm">Selesai</a>
                            @endif
                            <a href="/transaksi/edit/{{ $t->id_transaksi }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/transaksi/delete/{{ $t->id_transaksi }}" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection