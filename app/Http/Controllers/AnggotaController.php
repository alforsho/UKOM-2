<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        // Join manual tabel users dan anggota menggunakan Query Builder
        $users = DB::table('users')
            ->leftJoin('anggota', 'users.id', '=', 'anggota.user_id')
            ->select('users.*', 'anggota.nis', 'anggota.kelas', 'anggota.jurusan', 'anggota.no_telp')
            ->orderBy('users.id', 'desc')
            ->get();

        return view('anggota.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required'
        ]);

        DB::transaction(function () use ($request) {
            // Simpan ke tabel users
            $idUser = DB::table('users')->insertGetId([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'created_at' => now(),
            ]);

            // Jika role siswa, isi tabel anggota
            if ($request->role == 'siswa') {
                DB::table('anggota')->insert([
                    'user_id' => $idUser,
                    'nis' => $request->nis,
                    'nama_anggota' => $request->nama,
                    'kelas' => $request->kelas,
                    'jurusan' => $request->jurusan,
                    'no_telp' => $request->no_telp,
                    'created_at' => now(),
                ]);
            }
        });

        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}