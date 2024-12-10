@extends('layouts.layout')

@section('content')
    <form action="{{ route('book.store') }}" method="POST" class="card p-5">
        @csrf
        @if (Session::get('success'))
            <div class="alert alert-success"> {{ Session::get('success') }}</div>
        @endif
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        {{-- @csrf
        @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    {{-- Mengecek Jika Errors --}}
        {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                {{-- Memakai looping karena array(banyak data) --}}
        {{-- @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif   --}}
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Buku :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Jenis Buku :</label>
            <div class="col-sm-10">
                <select class="form-select" name="type" id="type">
                    <option selected disabled hidden>Pilih Jenis Buku</option>
                    <option value="komik">Komik</option>
                    <option value="novel">Novel</option>
                    <option value="majalah">Majalah</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="author" class="col-sm-2 col-form-label">Penulis :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="author" name="author">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="year" class="col-sm-2 col-form-label">Tahun :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="year" name="year">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stok :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="stock" name="stock">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Tambah Buku</button>
    </form>
@endsection
