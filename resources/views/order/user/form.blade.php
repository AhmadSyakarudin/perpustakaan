@extends('layouts.layout')

@section('content')
    <div class="container mt-3">
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <form action="{{ route('pinjam.pinjam.store') }}" method="POST" class="card w-75 mx-auto my-5 p-5">
            @csrf
            <p>Penanggung Jawab: <b>{{ Auth::user()->name }}</b></p>

            <div class="row mb-3">
                <label for="borrower_name" class="col-sm-2 col-form-label">Nama Peminjam</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="borrower_name" name="name_customer" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="orders" class="col-sm-2 col-form-label">Buku</label>
                <div class="col-sm-10">
                    <div class="d-flex mb-2">
                        <select name="orders[]" class="form-select" required>
                            <option selected hidden disabled>Pilih Buku</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}">
                                    {{ $book->name }} (Tersedia: {{ $book->stock }} Buku)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="orders-wrap"></div>
                    <p style="cursor: pointer" class="text-primary" id="add-select">+ Tambah Buku</p>
                </div>
            </div>

            <button type="submit" class="btn btn-block btn-lg btn-primary">Konfirmasi Peminjaman</button>
        </form>

    </div>
@endsection

@push('script')
    <script>
        let no = 2;

        // Tambahkan dropdown baru untuk memilih buku
        $("#add-select").on("click", function() {
            let html = `
                <div id="orders-${no}" class="d-flex mb-2">
                    <select name="orders[]" class="form-select" required>
                        <option selected hidden disabled>Pilih Buku ${no}</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}">
                                {{ $book->name }} (Tersedia: {{ $book->stock }} Buku)
                            </option>
                        @endforeach
                    </select>
                    <span style="cursor: pointer" class="text-danger p-2" onclick="deleteSelect('orders-${no}')">X</span>
                </div>`;
            $("#orders-wrap").append(html);
            no++;
        });

        // Hapus dropdown yang ditambahkan
        function deleteSelect(id) {
            $(`#${id}`).remove();
            no--;
        }
    </script>
@endpush
