<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 320px; }
        h2 { text-align: center; color: #333; margin-top: 0; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; transition: 0.3s; }
        input:focus { border-color: #2563eb; outline: none; }
        button { width: 100%; padding: 12px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 16px; transition: 0.3s; }
        button:hover { background: #1d4ed8; }
        .error { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; font-size: 0.85rem; text-align: center; margin-bottom: 15px; }
        .success { background: #dcfce7; color: #15803d; padding: 10px; border-radius: 6px; font-size: 0.85rem; text-align: center; margin-bottom: 15px; }
        p.footer { text-align: center; font-size: 0.9rem; margin-top: 20px; color: #666; }
        a { color: #2563eb; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login</h2>

        {{-- Sesuai dengan with('loginError') di Controller --}}
        @if(session('loginError')) 
            <div class="error">{{ session('loginError') }}</div> 
        @endif

        {{-- Sesuai dengan with('success') setelah register --}}
        @if(session('success')) 
            <div class="success">{{ session('success') }}</div> 
        @endif
        
        <form action="/login" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Masuk</button>
        </form>

        <p class="footer">Belum punya akun? <a href="/register">Daftar Siswa</a></p>
    </div>
</body>
</html>