<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // halaman login
    public function index()
    {
        return view('login');
    }

    // REGISTER
    public function register(Request $request)
    {
        // VALIDASI
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:3'
        ]);

        // SIMPAN USER
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pmik'
        ]);

        // CEK BERHASIL TERSIMPAN
        if (!$user) {
            return back()->with('register_error', 'Register gagal disimpan');
        }

        // LOGIN OTOMATIS
        Auth::login($user);

        // REDIRECT ROLE
        return $this->redirectByRole($user);
    }

    // LOGIN
    public function authenticate(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return $this->redirectByRole(Auth::user());
        }

        return back()->with('error', 'Login gagal');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // REDIRECT ROLE
    private function redirectByRole($user)
    {
        if ($user->role == 'pmik') {
            return redirect('/dashboard-pmik');
        }

        if ($user->role == 'dokter') {
            return redirect('/dashboard-dokter');
        }

        if ($user->role == 'apoteker') {
            return redirect('/dashboard-apoteker');
        }

        return redirect('/');
    }
}