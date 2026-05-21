@extends('dashboard-apoteker') 
@section('hide_search', true)
@section('content')
<style>
    /* Styling Container Utama */
    .notif-wrapper {
        padding: 30px;
        background-color: #fafbfe;
        min-height: 100vh;
    }

    /* Styling Header Teks */
    .notif-title {
        color: #5c1626;
        font-weight: 800;
        margin-bottom: 5px;
        font-size: 28px;
    }
    .notif-subtitle {
        color: #888;
        margin-bottom: 30px;
        font-size: 15px;
    }

    /* Styling Tombol Filter */
    .filter-tabs {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
    }
    .btn-filter {
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid #ddd;
        color: #333;
        background: #fff;
        font-size: 14px;
        transition: 0.3s;
    }
    .btn-filter.active {
        background-color: #5c1626;
        color: #fff;
        border-color: #5c1626;
    }
    .btn-filter:hover:not(.active) {
        background-color: #f1f1f1;
    }

    /* Styling Kartu Notifikasi */
    .notif-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        border: 1px solid #f0f0f0;
        margin-bottom: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .notif-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    /* Styling Lingkaran Icon */
    .icon-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-right: 20px;
    }
    
    /* Varian Warna Icon */
    .icon-success { background-color: #e8f8f0; color: #4caf50; }
    .icon-warning { background-color: #fff7e6; color: #ff9800; }
    .icon-info { background-color: #e8f4fd; color: #2196f3; }

    /* Titik Status (Dot) */
    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 20px;
    }
    .dot-success { background-color: #4caf50; }
    .dot-warning { background-color: #ff9800; }
    .dot-info { background-color: #2196f3; }

    /* Styling Teks Konten */
    .notif-content {
        flex: 1;
    }
    .notif-header-text {
        font-weight: 700;
        color: #222;
        margin-bottom: 5px;
        font-size: 15px;
    }
    .notif-desc {
        color: #777;
        font-size: 14px;
        margin: 0;
    }
</style>

<div class="notif-wrapper">
    <h2 class="notif-title">Notifikasi</h2>
    <p class="notif-subtitle">Informasi terbaru dari sistem</p>

    <div class="filter-tabs">
        <a href="#" class="btn-filter active">Semua</a>
    </div>

    @forelse($notifikasis as $notif)
        
        @php
            $iconClass = '';
            $iconName = '';
            $dotClass = '';

            if($notif->tipe == 'success') {
                $iconClass = 'icon-success';
                $iconName = 'checkmark-outline';
                $dotClass = 'dot-success';
            } elseif($notif->tipe == 'warning') {
                $iconClass = 'icon-warning';
                $iconName = 'print-outline';
                $dotClass = 'dot-warning';
            } else {
                $iconClass = 'icon-info';
                $iconName = 'document-text-outline';
                $dotClass = 'dot-info';
            }
        @endphp

        <div class="notif-card">
            <div class="icon-circle {{ $iconClass }}">
                <ion-icon name="{{ $iconName }}"></ion-icon>
            </div>
            <div class="status-dot {{ $dotClass }}"></div>
            <div class="notif-content">
                <div class="notif-header-text">{{ $notif->judul }}</div>
                <p class="notif-desc">{{ $notif->deskripsi }}</p>
            </div>
        </div>

    @empty
        <div style="text-align: center; padding: 40px; color: #888;">
            <ion-icon name="notifications-off-outline" style="font-size: 40px; color: #ccc; margin-bottom: 10px;"></ion-icon>
            <p>Belum ada notifikasi saat ini.</p>
        </div>
    @endforelse

</div>

@endsection