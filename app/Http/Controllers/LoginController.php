<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    // Register dengan konfirmasi password
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:3'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'pmik'
        ]);

        Auth::login($user);

        return $this->redirectByRole($user);
    }

    // Login
    public function authenticate(Request $request)
    {
        $data = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            Auth::user()->update(['last_seen' => now()]);
            return $this->redirectByRole(Auth::user());
        }

        return back()->with('error', 'Login gagal');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ✅ Kirim link reset password ke email
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('forgot_success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox.');
        }

        return back()->with('forgot_error', 'Email tidak ditemukan dalam sistem.');
    }

    // ✅ Tampilkan form reset password (dari link di email)
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // ✅ Proses reset password
    public function processReset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect('/')->with('reset_success', 'Password berhasil direset! Silakan login.');
        }

        return back()->withErrors(['email' => 'Token tidak valid atau sudah kadaluarsa.']);
    }

    private function redirectByRole($user)
    {
        if ($user->role == 'admin')    return redirect('/admin/dashboard');
        if ($user->role == 'pmik')     return redirect('/dashboard-pmik');
        if ($user->role == 'dokter')   return redirect('/dashboard-dokter');
        if ($user->role == 'apoteker') return redirect('/dashboard-apoteker');
        return redirect('/');
    }
}