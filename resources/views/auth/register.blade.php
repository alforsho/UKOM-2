<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota - Perpustakaan</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; }
        .register-container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        h2 { text-align: center; color: #1a73e8; margin-bottom: 10px; }
        p.subtitle { text-align: center; color: #666; margin-bottom: 25px; font-size: 14px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; color: #444; font-size: 14px; }
        /* Tambahkan select di sini agar style-nya sama dengan input */
        input, select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; transition: 0.3s; background-color: white; }
        input:focus, select:focus { border-color: #1a73e8; outline: none; box-shadow: 0 0 0 2px rgba(26,115,232,0.2); }
        button { width: 100%; padding: 12px; background: #1a73e8; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 10px; transition: 0.3s; }
        button:hover { background: #1557b0; }
        .footer-link { text-align: center; margin-top: 20px; font-size: 14px; color: #666; }
        .footer-link a { color: #1a73e8; text-decoration: none; font-weight: bold; }
        .error-list { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Daftar Anggota</h2>
    <p class="subtitle">Silakan isi data diri untuk membuat akun siswa</p>

    @if ($errors->any())
        <div class="error-list">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/register" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}" placeholder="Untuk login" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Minimal 5 karakter" required>
        </div>

        <div style="display: flex; gap: 10px;">
            <div class="form-group" style="flex: 1;">
                <label>NIS</label>
                <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Nomor Induk" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Kelas</label>
                <select name="kelas" required>
                    <option value="" disabled {{ old('kelas') ? '' : 'selected' }}>Pilih Kelas</option>
                    <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>10</option>
                    <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>11</option>
                    <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>12</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Jurusan</label>
            <select name="jurusan" required>
                <option value="" disabled {{ old('jurusan') ? '' : 'selected' }}>Pilih Jurusan</option>
                <option value="RPL" {{ old('jurusan') == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak (RPL)</option>
                <option value="TKJ" {{ old('jurusan') == 'TKJ' ? 'selected' : '' }}>Teknik Komputer Jaringan (TKJ)</option>
                <option value="MM" {{ old('jurusan') == 'MM' ? 'selected' : '' }}>Multimedia (MM)</option>
                <option value="DKV" {{ old('jurusan') == 'DKV' ? 'selected' : '' }}>DKV</option>
                <option value="SIJA" {{ old('jurusan') == 'SIJA' ? 'selected' : '' }}>SIJA</option>
            </select>
        </div>

        <div class="form-group">
            <label>No. Telepon</label>
            <input type="text" name="no_telp" value="{{ old('no_telp') }}" placeholder="0812xxxx" required>
        </div>

        <button type="submit">Daftar Sekarang</button>
    </form>

    <div class="footer-link">
        Sudah punya akun? <a href="/login">Masuk di sini</a>
    </div>
</div>

</body>
</html>