<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; // <-- INI YANG DITAMBAHKAN AGAR ERROR HILANG
use Carbon\Carbon;
use App\Models\Resep;
use Illuminate\Support\Facades\Auth; // <--- TAMBAHKAN INI
use Illuminate\Support\Facades\Hash; // <--- TAMBAHKAN INI (Untuk ganti password)

class DokterController extends Controller
{
    // Method untuk menampilkan halaman Dashboard Dokter utama
  public function index()
    {
        // 1. Total Pasien Keseluruhan
        $totalPasien = Pasien::count();
        
        // 2. Resep Dibuat Hari Ini (Menggunakan tanggal input sistem / created_at)
        $hariIni = \Carbon\Carbon::today(config('app.timezone')); // Menyesuaikan zona waktu aplikasi
        $resepDibuat = Resep::whereDate('created_at', $hariIni)->count();
        
        // 3. Pasien Belum Diberi Resep
        $pasienSudahResep = Resep::pluck('pasien_id')->toArray();
        $pasienBelumResep = Pasien::whereNotIn('id', $pasienSudahResep)->count();
        
        // 4. Data Tabel: 5 Riwayat Resep TERBARU (Apapun tanggal di formnya, yang baru diinput akan muncul paling atas)
        $riwayatResep = Resep::with('pasien')
                             ->orderBy('created_at', 'desc')
                             ->take(5) // Mengambil 5 data terbaru agar tabel tidak kepanjangan
                             ->get();

        return view('dokter.dashboard', compact(
            'totalPasien', 
            'resepDibuat', 
            'pasienBelumResep', 
            'riwayatResep'
        ));
    }

    // Method untuk menampilkan halaman Data Pasien khusus Dokter
    public function dataPasien()
    {
        $pasiens = Pasien::with('resep')
            ->withCount('resep')
            ->orderBy('resep_count', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Memanggil file pasien.blade.php yang ada di dalam folder 'dokter'
        return view('dokter.pasien', compact('pasiens')); 
    }

    // Method untuk melihat detail pasien khusus dokter
    public function showPasien($id)
    {
        // Mencari pasien berdasarkan ID, jika tidak ada akan memunculkan error 404
        $pasien = Pasien::findOrFail($id); 
        
        // Memanggil file view detail pasien
        return view('dokter.pasien-detail', compact('pasien'));
    }

    public function profile()
{
    $user = Auth::user();
    // Merujuk ke folder dokter file profile-dokter.blade.php
    return view('dokter.profile-dokter', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Validasi data
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8|confirmed', // Isi jika ingin ganti password
    ]);

    // Update Nama dan Email
    $user->name = $request->name;
    $user->email = $request->email;

    // Jika password diisi, maka update password
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return back()->with('success', 'Profil Anda berhasil diperbarui!');
}
}