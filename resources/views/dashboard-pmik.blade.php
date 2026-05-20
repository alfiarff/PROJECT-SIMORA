@extends('layouts.app')

@section('title', 'Dashboard PMIK')
@section('search_action', '/pasien')
@section('search_placeholder', 'Cari pasien...')

@section('sidebar')
<div class="navigation">
    <ul>
        <li class="logo-item">
            <a href="/dashboard-pmik">
                <span class="icon">
                    <img src="{{ asset('images/logosimora2.png') }}" class="logo-img" alt="Logo SI-MORA">
                </span>
                <h2 class="title">SI-MORA</h2>
            </a>
        </li>
        <li>
            <a href="/dashboard-pmik">
                <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                <span class="title">Beranda</span>
            </a>
        </li>
        <li>
            <a href="/pasien">
                <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                <span class="title">Data Pasien</span>
            </a>
        </li>
        <li>
            <a href="/pasien/create">
                <span class="icon"><ion-icon name="person-add-outline"></ion-icon></span>
                <span class="title">Tambah Pasien</span>
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
    {{-- Konten Utama Halaman Beranda PMIK --}}
    <div class="container mt-4">
        <div class="alert alert-success">
            Selamat datang di Dashboard PMIK, <strong>{{ Auth::user()->name ?? 'User' }}</strong>!
        </div>
        
        </div>
@endsection