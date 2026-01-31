<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $bukus = DB::table('buku')->where('stok', '>', 0)->get();
        
        // Konfigurasi Denda
        $harga_denda_per_hari = 1000; 
        $batas_hari_pinjam = 7;

        $query = DB::table('transaksi')
            ->join('buku', 'transaksi.id_buku', '=', 'buku.id_buku')
            ->select('transaksi.*', 'buku.nama_buku')
            ->orderBy('transaksi.id_transaksi', 'desc');

        if ($user->role == 'admin') {
            $transaksis = $query->join('users', 'transaksi.id', '=', 'users.id')
                ->addSelect('users.nama')
                ->get();
        } else {
            $transaksis = $query->where('transaksi.id', $user->id)->get();
        }

        // LOGIKA HITUNG DENDA OTOMATIS (Berjalan di memori untuk tampilan)
        foreach ($transaksis as $t) {
            $tgl_pinjam = Carbon::parse($t->tanggal_trs);
            $tgl_deadline = $tgl_pinjam->copy()->addDays($batas_hari_pinjam);
            $tgl_sekarang = Carbon::now();

            if ($t->status == 'Pinjam' && $tgl_sekarang->gt($tgl_deadline)) {
                $selisih_hari = $tgl_sekarang->diffInDays($tgl_deadline);
                $t->total_denda = $selisih_hari * $harga_denda_per_hari;
            } else {
                $t->total_denda = 0;
            }
        }

        if ($user->role == 'admin') {
            return view('transaksi.admin', compact('transaksis', 'bukus'));
        } else {
            return view('transaksi.siswa', compact('transaksis', 'bukus'));
        }
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->role == 'admin' ? $request->user_id : auth()->id();

        // FILTER 1: Batas Maksimal Pinjam 3 Buku
        $cekPinjam = DB::table('transaksi')->where('id', $userId)->where('status', 'Pinjam')->count();
        if ($cekPinjam >= 3) {
            return back()->with('error', 'Gagal! Kamu masih meminjam 3 buku. Balikin dulu ya.');
        }

        // FILTER 2: Cek Stok Buku
        $buku = DB::table('buku')->where('id_buku', $request->id_buku)->first();
        if (!$buku || $buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku ini sudah habis!');
        }

        DB::transaction(function () use ($request, $userId) {
            DB::table('transaksi')->insert([
                'id' => $userId,
                'id_buku' => $request->id_buku,
                'tanggal_trs' => now(),
                'status' => 'Pinjam',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('buku')->where('id_buku', $request->id_buku)->decrement('stok');
        });

        return back()->with('success', 'Buku berhasil dipinjam! Batas waktu 7 hari.');
    }

    public function edit($id)
    {
        $transaksi = DB::table('transaksi')->where('id_transaksi', $id)->first();
        
        // Keamanan: Siswa dilarang ngintip/edit punya orang lain lewat URL
        if (auth()->user()->role == 'siswa' && $transaksi->id != auth()->id()) {
            return redirect('/transaksi')->with('error', 'Akses dilarang!');
        }

        $bukus = DB::table('buku')->get();
        return view('transaksi.edit', compact('transaksi', 'bukus'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = DB::table('transaksi')->where('id_transaksi', $id)->first();
        
        // Hanya admin yang boleh ganti user_id dan status di form edit
        $userId = auth()->user()->role == 'admin' ? $request->user_id : auth()->id();
        $status = auth()->user()->role == 'admin' ? $request->status : $transaksi->status;

        DB::table('transaksi')->where('id_transaksi', $id)->update([
            'id' => $userId,
            'id_buku' => $request->id_buku,
            'status' => $status,
            'updated_at' => now(),
        ]);

        return redirect('/transaksi')->with('success', 'Data transaksi berhasil diperbarui!');
    }

    public function kembali($id)
    {
        $tr = DB::table('transaksi')->where('id_transaksi', $id)->first();
        
        if ($tr && $tr->status == 'Pinjam') {
            DB::transaction(function () use ($tr, $id) {
                DB::table('transaksi')->where('id_transaksi', $id)->update([
                    'status' => 'Kembali', 
                    'updated_at' => now()
                ]);
                DB::table('buku')->where('id_buku', $tr->id_buku)->increment('stok');
            });
            return back()->with('success', 'Buku telah dikembalikan. Stok buku otomatis bertambah!');
        }
        return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
    }

    public function destroy($id)
    {
        $transaksi = DB::table('transaksi')->where('id_transaksi', $id)->first();

        if (!$transaksi) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        // FILTER 3: Keamanan Data & Stok
        if ($transaksi->status == 'Pinjam') {
            return back()->with('error', 'Dilarang menghapus! Buku masih dipinjam. Selesaikan dulu pengembaliannya.');
        }

        // Keamanan: Siswa dilarang hapus riwayat orang lain
        if (auth()->user()->role == 'siswa' && $transaksi->id != auth()->id()) {
            return redirect('/transaksi')->with('error', 'Akses dilarang!');
        }

        DB::table('transaksi')->where('id_transaksi', $id)->delete();
        return back()->with('success', 'Riwayat transaksi telah dihapus.');
    }
}