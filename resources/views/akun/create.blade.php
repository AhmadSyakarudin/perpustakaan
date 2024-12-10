@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Halaman Menambahkan Pengguna</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                    <form action="{{ route('akun.store') }}" method="POST">
                        @csrf

                        {{-- Mengecek Jika Success --}}
                        @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        {{-- Mengecek Jika Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    {{-- Memakai looping karena array (banyak data) --}}
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Nama Pengguna --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Pengguna:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}">
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}">
                        </div>

                        {{-- Tipe Pengguna --}}
                        <div class="mb-3">
                            <label for="tipe_pengguna" class="form-label">Tipe Pengguna:</label>
                            <select class="form-select" name="role" id="tipe_pengguna">
                                <option selected disabled hidden>Pilih Tipe Pengguna</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
