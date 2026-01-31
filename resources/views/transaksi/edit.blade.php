@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="card shadow border-0 mx-auto" style="max-width: 500px;">
        <div class="card-header {{ auth()->user()->role == 'admin' ? 'bg-warning' : 'bg-info text-white' }} fw-bold text-center">
            EDIT TRANSAKSI ({{ strtoupper(auth()->user()->role) }})
        </div>
        <div class="card-body p-4">
            <form action="/transaksi/update/{{ $transaksi->id_transaksi }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="small fw-bold">NAMA SISWA</label>
                    @if(auth()->user()->role == 'admin')
                        <select name="user_id" class="form-select">
                            @foreach(DB::table('users')->where('role', 'siswa')->get() as $u)
                                <option value="{{ $u->id }}" {{ $u->id == $transaksi->id ? 'selected' : '' }}>{{ $u->nama }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" class="form-control bg-light" value="{{ auth()->user()->nama }}" readonly>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="small fw-bold">JUDUL BUKU</label>
                    <select name="id_buku" class="form-select">
                        @foreach($bukus as $b)
                            <option value="{{ $b->id_buku }}" {{ $b->id_buku == $transaksi->id_buku ? 'selected' : '' }}>{{ $b->nama_buku }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="small fw-bold">STATUS</label>
                    @if(auth()->user()->role == 'admin')
                        <select name="status" class="form-select">
                            <option value="Pinjam" {{ $transaksi->status == 'Pinjam' ? 'selected' : '' }}>Pinjam</option>
                            <option value="Kembali" {{ $transaksi->status == 'Kembali' ? 'selected' : '' }}>Kembali</option>
                        </select>
                    @else
                        <input type="text" class="form-control bg-light" value="{{ $transaksi->status }}" readonly>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">UPDATE DATA</button>
            </form>
        </div>
    </div>
</div>
@endsection