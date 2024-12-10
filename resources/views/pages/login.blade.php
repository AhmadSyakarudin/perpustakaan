@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('login.proses') }}" class="card p-5 mt-5" method="POST">
                    @csrf
                    <h4 class="card-title text-center mb-4">Login</h4>

                    <!-- Alert Error jika ada validasi gagal -->
                    @if ($errors->any())
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: '{{ $errors->first() }}', // Menampilkan error pertama dari validasi
                            });
                        </script>
                    @endif

                    <div class="mb-3">
                        <label for="email" class="form-label">Input Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
                        <!-- Menampilkan error khusus untuk email -->
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Input Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                        <!-- Menampilkan error khusus untuk password -->
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Alert untuk login gagal -->
    @if (session('failed'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '{{ session("failed") }}',
                footer: '<a href="#">Why do I have this issue?</a>'
            });
        </script>
    @endif

    <!-- Alert untuk login berhasil -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Welcome!',
                html: '{!! session("success") !!}'
            });
        </script>
    @endif

    <!-- Alert jika mencoba mengakses halaman login setelah login -->
    @if (session('danger'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session("danger") }}',
                footer: '<a href="#">Why do I have this issue?</a>'
            });
        </script>
    @endif
@endsection
