@extends('layouts.layout')

@section('content')
    <!-- Display success and deleted messages -->
    @if (session('berhasil'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: `{!! session('berhasil') !!}`
            });
        });
    </script>
@endif


    @if (Session::get('deleted'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('deleted') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Table styling -->
    <div class="table-responsive shadow-sm p-3 mb-5 bg-body rounded">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok Tersedia</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($books as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->author }}</td>
                        <td>{{ $item->year }}</td>
                        <td>{{ $item->stock }}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('book.edit', $item->id) }}" class="btn btn-primary me-3">Edit</a>
                            <form action="{{ route('book.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
