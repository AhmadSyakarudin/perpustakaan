<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.10/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar bg-primary p-3 text-white" style="width: 250px; position: fixed; height: 100vh; top: 0;">
            <h4 class="mb-4">Perpustakaan App</h4>
            @if (Auth::check())
                <div class="d-flex flex-column gap-3">
                    <a class="nav-link {{ Route::is('landing_page') ? 'active' : '' }} py-2"
                        href="{{ route('landing_page') }}">Dashboard</a>
                    @if (Auth::user()->role == 'admin')
                        <div class="dropdown mb-2">
                            <a class="nav-link dropdown-toggle py-2" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Buku</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item py-2" href="{{ route('book.index') }}">Data Buku</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('book.create') }}">Tambah</a></li>
                                <li><a class="dropdown-item py-2" href="#">Stok</a></li>
                            </ul>
                        </div>
                        <a class="nav-link py-2 mb-2" href="{{ route('peminjaman.admin') }}">Peminjaman</a>
                        <a class="nav-link py-2 mb-2" href="{{ route('akun.index') }}">Kelola Akun</a>
                    @endif
                    @if (Auth::user()->role == 'user')
                        <a class="nav-link py-2 mb-2" href="{{ route('pinjam.index') }}">Peminjaman</a>
                    @endif
                    <a class="nav-link py-2" href="{{ route('logout') }}">Logout</a>
                </div>
            @endif
        </div>
        <div class="container mt-5" style="margin-left: 250px;">
            @yield('content')
        </div>
    </div>
</body>

</html>

