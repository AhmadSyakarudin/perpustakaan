@extends('layouts.layout')

@section('content')


    <form action="{{ route('akun.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')

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
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Nama Pengguna --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Pengguna:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email"
                value="{{ old('email', $user->email) }}">
        </div>

        {{-- Tipe Pengguna --}}
        <div class="mb-3">
            <label for="tipe_pengguna" class="form-label">Tipe Pengguna:</label>
            <select class="form-select" name="role" id="tipe_pengguna">
                <option selected disabled hidden>Pilih Tipe Pengguna</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password (Opsional):</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
        </div>

        {{-- Tombol Submit --}}
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
@endsection
