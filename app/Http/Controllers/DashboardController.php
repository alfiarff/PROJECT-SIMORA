<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // Total semua pasien
    $totalPasien = Pasien::count();

    // Hitung pasien yang terdaftar hari ini saja
    $pasienHariIni = Pasien::whereDate('created_at', today())->count();

    // Hitung rekam medis aktif (asumsi status 'Aktif' atau sekadar total pasien)
    $rekamMedisAktif = Pasien::count(); 

    // Ambil 5 pasien terbaru
    $pasienTerbaru = Pasien::latest()->take(5)->get();

    return view('home-pmik', compact('totalPasien', 'pasienHariIni', 'rekamMedisAktif', 'pasienTerbaru'));
}
}