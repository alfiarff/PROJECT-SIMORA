<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; // Wajib dipanggil agar bisa mengambil data dari database

class PmikController extends Controller
{
    /**
     * Menampilkan halaman utama Data Pasien (Tabel)
     */
    public function index()
    {
        // Mengambil data pasien, diurutkan dari yang terbaru. (Bisa diganti dengan paginate jika datanya banyak)
        $data = Pasien::orderBy('created_at', 'desc')->get(); 
        
        // Pastikan nama view sesuai dengan file blade tabel pasien PMIK Anda
        return view('pmik.pasien', compact('data')); 
    }

    /**
     * Menampilkan halaman Detail Data Pasien (Full Page)
     */
    public function detailPasien($id)
    {
        // Mencari data pasien berdasarkan ID, jika tidak ada akan muncul error 404
        $pasien = Pasien::findOrFail($id);
        
        // Membuka file detail_pasien.blade.php yang baru saja kita buat tadi
        return view('pmik.detail_pasien', compact('pasien'));
    }
}