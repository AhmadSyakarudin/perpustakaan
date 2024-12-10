<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Charts\MonthlyUsersChart;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('akun.index', compact('users'));
    }


    // public function chart()
    // {
    //     // Menggunakan class MonthlyUsersChart
    //     $chart = (new MonthlyUsersChart)
    //         ->setType('bar') // Tipe chart: bar, line, pie, dll.
    //         ->setTitle('Monthly User Registrations')
    //         ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])
    //         ->setDataset([
    //             [
    //                 'name' => 'Users',
    //                 'data' => [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120],
    //             ],
    //         ]);

    //     return view('akun.chart', compact('chart'));
    // }


    public function landing()
    {
        return view('pages.index');
    }

    public function showLogin()
    {
        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            // Pengguna sudah login, alihkan ke halaman utama atau dashboard
            return redirect()->route('landing_page')->with('danger', 'Anda sudah login, tidak perlu mengakses halaman login!');
        }

        // Jika belum login, tampilkan halaman login
        return view('pages.login');
    }

    public function loginAuth(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        // Cek jika login berhasil
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('landing_page')->with('success', 'Selamat datang kembali, <b>' . Auth::user()->name . '</b>');
        }

        // Jika login gagal
        return redirect()->route('login.auth')->with('failed', 'Email atau password salah!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.auth')->with('success', 'Anda Berhasil logout!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('akun.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,user',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login.auth')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('akun.index')->with('error', 'Pengguna tidak ditemukan!');
        }

        return view('akun.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
            'password' => 'nullable|min:8',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('akun.index')->with('error', 'Pengguna tidak ditemukan!');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('akun.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('akun.index')->with('error', 'Pengguna tidak ditemukan!');
        }

        $user->delete();
        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }
}
