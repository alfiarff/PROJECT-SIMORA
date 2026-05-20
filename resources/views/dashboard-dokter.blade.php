@extends('layouts.app')

@section('title', 'Dashboard Dokter')
@section('search_action', '/resep')
@section('search_placeholder', 'Cari pasien / resep...')

@section('sidebar')
<div class="navigation">
    <ul>
        <li class="logo-item">
            <a href="/dashboard-dokter">
                <span class="icon">
                    <img src="{{ asset('images/logosimora2.png') }}" class="logo-img" alt="Logo SI-MORA">
                </span>
                <h2 class="title">SI-MORA</h2>
            </a>
        </li>
        <li>
            <a href="/dashboard-dokter">
                <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                <span class="title">Beranda</span>
            </a>
        </li>
        <li>
            <a href="/dokter/pasien">
                <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                <span class="title">Data Pasien</span>
            </a>
        </li>
        <li>
            <a href="/resep/create">
                <span class="icon"><ion-icon name="create-outline"></ion-icon></span>
                <span class="title">Tambah Resep</span>
            </a>
        </li>
        <li>
            <a href="/resep">
                <span class="icon"><ion-icon name="document-text-outline"></ion-icon></span>
                <span class="title">Data Resep</span>
            </a>
        </li>
        <li>
            <a href="/profile">
                <span class="icon"><ion-icon name="settings-outline"></ion-icon></span>
                <span class="title">Pengaturan</span>
            </a>
        </li>
        <li>
            <a href="#" onclick="event.preventDefault(); openLogoutModal();">
                <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                <span class="title">Keluar</span>
            </a>
        </li>
    </ul>
</div>
@endsection

@section('content')
    {{-- Card Metrik Dashboard Dokter --}}
    <div class="cardBox">
        <div class="card">
            <div>
                <div class="numbers">{{ $totalPasien ?? 7 }}</div>
                <div class="cardName">Total Pasien</div>
            </div>
            <div class="iconBx">
                <ion-icon name="people-outline"></ion-icon>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers">{{ $resepHariIni ?? 0 }}</div>
                <div class="cardName">Resep Hari Ini</div>
            </div>
            <div class="iconBx">
                <ion-icon name="document-text-outline"></ion-icon>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers">{{ $belumDiberiResep ?? 0 }}</div>
                <div class="cardName">Belum Diberi Resep</div>
            </div>
            <div class="iconBx">
                <ion-icon name="alert-circle-outline"></ion-icon>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Resep Hari Ini --}}
    <div class="details">
        <div class="recentOrders">
            <div class="cardHeader">
                <h2>Riwayat Resep Hari Ini</h2>
                <a href="/resep" class="btn-view">Lihat Semua</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>No RM</td>
                        <td>Diagnosa</td>
                        <td>Obat</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data statis, silakan sesuaikan dengan @foreach dari database --}}
                    <tr>
                        <td>Putri</td>
                        <td>RM-240007</td>
                        <td>Influenza</td>
                        <td>Paracetamol</td>
                        <td><span class="status delivered">Selesai</span></td>
                    </tr>
                    <tr>
                        <td>Budi Santoso</td>
                        <td>RM-240006</td>
                        <td>Hipertensi</td>
                        <td>Paracetamol</td>
                        <td><span class="status delivered">Selesai</span></td>
                    </tr>
                    <tr>
                        <td>Amanda Manopo</td>
                        <td>RM-240005</td>
                        <td>Influenza</td>
                        <td>Paratusin</td>
                        <td><span class="status delivered">Selesai</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection