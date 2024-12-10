@extends('layouts.layout')

@section('content')
    <div class="jumbotron py-4 px-5">
        <h1 class="display-4">
            Selamat Datang <b>{{ Auth::user()->name }}</b>
        </h1>
        <hr class="my-4">
        <p>Aplikasi ini digunakan untuk mengelola data buku.</p>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Welcome!',
                html: '{!! session('success') !!}'
            });
        </script>
    @endif
    @if (session('danger'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '{!! session('danger') !!}'
            });
        </script>
    @endif
    @if (session('notAccess'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '{!! session('notAccess') !!}'
            });
        </script>
    @endif
@endsection
