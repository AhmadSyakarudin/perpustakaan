@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Halaman Edit Buku</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                    {{-- Form untuk mengedit buku --}}
                    <form action="{{ route('book.update', $book->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        {{-- Menampilkan pesan sukses jika ada --}}
                        @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        {{-- Menampilkan pesan error jika ada --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Nama Buku --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Buku:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $book->name) }}">
                        </div>

                        {{-- Jenis Buku --}}
                        <div class="mb-3">
                            <label for="type" class="form-label">Jenis Buku:</label>
                            <select class="form-select" name="type" id="type">
                                <option selected disabled hidden>Pilih Jenis Buku</option>
                                <option value="komik" {{ $book['type'] == 'komik' ? 'selected' : '' }}>Komik</option>
                                <option value="novel" {{ $book['type'] == 'novel' ? 'selected' : '' }}>Novel</option>
                                <option value="majalah" {{ $book['type'] == 'majalah' ? 'selected' : '' }}>Ensiklopedia</option>
                            </select>
                        </div>

                        {{-- Pengarang --}}
                        <div class="mb-3">
                            <label for="author" class="form-label">Pengarang:</label>
                            <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}">
                        </div>

                        {{-- Tahun Terbit --}}
                        <div class="mb-3">
                            <label for="year" class="form-label">Tahun Terbit:</label>
                            <input type="number" class="form-control" id="year" name="year" value="{{ old('year', $book->year) }}">
                        </div>

                        {{-- Stok Buku --}}
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stok Buku:</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $book->stock) }}">
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Buku</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
