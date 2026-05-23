<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('profile.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:5',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $messages = [];

        // Update nama
        if ($request->name !== $user->name) {
            $user->name = $request->name;
            $messages[] = 'Nama Anda berhasil diperbarui!';
        }

        // Update email
        if ($request->email !== $user->email) {
            $user->email = $request->email;
            $messages[] = 'Email Anda berhasil diperbarui!';
        }

        // Update password
        if ($request->filled('password')) {

            // cek password lama wajib benar
            if (!Hash::check($request->current_password, $user->password)) {

                return redirect()->back()->withErrors([
                    'current_password' => 'Password lama yang Anda masukkan salah.'
                ])->withInput();

            }

            $user->password = Hash::make($request->password);

            $messages[] = 'Password Anda berhasil diperbarui!';
        }

        // Update foto
        if ($request->hasFile('foto')) {

            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $path = $request->file('foto')->store('profile_photos', 'public');

            $user->foto = $path;

            $messages[] = 'Foto profil berhasil diperbarui!';
        }

        // Tidak ada perubahan
        if (empty($messages)) {
            return redirect()->back()->with('success', 'Tidak ada perubahan data.');
        }

        $user->save();

        return redirect()->back()->with('success', implode(' ', $messages));
    }
}

