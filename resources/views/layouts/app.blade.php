<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { shadow: 0 2px 4px rgba(0,0,0,.1); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">📚 PERPUS-KU</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/buku">Data Buku</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/anggota">Data Anggota</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="/siswa/dashboard">Dashboard</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="/transaksi">Transaksi</a></li>
                </ul>
                <div class="d-flex align-items-center text-white">
                    <span class="me-3">Halo, {{ auth()->user()->nama }} ({{ ucfirst(auth()->user()->role) }})</span>
                    <form action="/logout" method="POST">@csrf <button class="btn btn-danger btn-sm">Logout</button></form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>