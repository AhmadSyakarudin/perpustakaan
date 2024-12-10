@extends('layouts.layout')

@section('content')
    <div class="container mt-3">
        @if (Session::get('success'))
            <div class="alert alert-success text-center">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center bg-light rounded p-3 shadow-sm">
            <form action="{{ route('pinjam.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <input type="date" name="search_day" class="form-control form-control-lg" placeholder="Pilih tanggal"
                    value="{{ request('tanggal') }}">
                <button type="submit" class="btn btn-primary btn-lg px-4">Cari</button>
                <a href="{{ route('pinjam.index') }}" class="btn btn-secondary btn-lg px-4">Clear</a>
            </form>
            <a href="{{ route('pinjam.create') }}" class="btn btn-success btn-lg px-4 shadow">+ Tambah Peminjaman</a>
        </div>

        <h3>Nama Peminjam Buku: {{ Auth::user()->name }}</h3>
        <table class="table-bordered table-striped mt-3 table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Buku yang Dipinjam</th>
                    <th>Total Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = ($orders->currentPage() - 1) * $orders->perPage() + 1; @endphp
                @foreach ($orders as $order)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $order->name_customer }}</td>
                        <td>
                            @foreach ($order->books as $book)
                                {{ $book['name'] }} ({{ $book['qty'] }})
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        <td class="text-center">{{ $order->sum_book }}</td>
                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('pinjam.show', $order->id) }}" class="btn btn-info btn-sm">Detail</a>

                            <!-- Form Hapus -->
                            <form action="{{ route('pinjam.destroy', $order->id) }}" method="POST"
                                style="display:inline;" id="delete-form-{{ $order->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $order->id }})">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links() }}
    </div>

    <script>
        function confirmDelete(orderId) {
            if (confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')) {
                document.getElementById('delete-form-' + orderId).submit();
            }
        }
    </script>
@endsection
