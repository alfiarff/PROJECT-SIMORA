@extends('layouts.app')

@section('title', 'Dashboard Apoteker')
@section('search_action', '/dashboard-apoteker')
@section('search_placeholder', 'Cari nama pasien / obat...')

{{-- ✅ SUNTIKKAN CSS KHUSUS APOTEKER --}}
@push('styles')
<style>
    /* Badge Notifikasi Sidebar */
    .navigation ul li { position: relative !important; }
    .badge-notif { position: absolute; right: 25px; top: 50%; transform: translateY(-50%); background-color: #e74c3c; color: white; font-size: 11px; font-weight: bold; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(231, 76, 60, 0.4); z-index: 100; pointer-events: none; transition: 0.3s ease; }
    .navigation.active .badge-notif { right: 18px; top: 15px; width: 15px; height: 15px; font-size: 9px; }

    /* Memperbaiki Card yang Memanjang */
    .cardBox .card { flex-direction: row !important; justify-content: space-between !important; align-items: center !important; height: 140px !important; border: none !important; box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08) !important; padding: 30px !important; }
</style>
@endpush

{{-- ✅ SUNTIKKAN FITUR BELL NOTIFIKASI KE TOPBAR --}}
@push('notif-bell')
<div class="notif-bell-wrapper" style="position:relative;">
    <div onclick="toggleNotifDropdown()" style="cursor:pointer; width:40px; height:40px; display:flex; align-items:center; justify-content:center; border-radius:50%; background:#f5f5f5; position:relative;">
        <ion-icon name="notifications-outline" style="font-size:22px; color:#555;"></ion-icon>
        @if(isset($notifBaru) && $notifBaru > 0)
            <span style="position:absolute; top:4px; right:4px; background:#e74c3c; color:#fff; font-size:9px; font-weight:bold; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center; line-height:1;">
                {{ $notifBaru > 9 ? '9+' : $notifBaru }}
            </span>
        @endif
    </div>

    {{-- Dropdown Notifikasi --}}
    <div id="notifDropdown" style="display:none; position:absolute; top:48px; right:0; width:300px; background:#fff; border-radius:12px; box-shadow:0 8px 25px rgba(0,0,0,0.15); z-index:9999; overflow:hidden;">
        <div style="padding:14px 18px; border-bottom:1px solid #f0f0f0; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-weight:700; color:#333; font-size:14px;">Notifikasi</span>
            <a href="/apoteker/notifikasi" style="font-size:12px; color:#75162d; text-decoration:none; font-weight:600;">Lihat semua →</a>
        </div>
        <div style="max-height:280px; overflow-y:auto;">
            @forelse($notifList ?? [] as $notif)
                @php
                    $iconName  = $notif->tipe == 'success' ? 'checkmark-outline' : ($notif->tipe == 'warning' ? 'print-outline' : 'document-text-outline');
                    $iconBg    = $notif->tipe == 'success' ? '#e8f8f0' : ($notif->tipe == 'warning' ? '#fff7e6' : '#e8f4fd');
                    $iconColor = $notif->tipe == 'success' ? '#4caf50' : ($notif->tipe == 'warning' ? '#ff9800' : '#2196f3');
                @endphp
                <div style="padding:10px 18px; display:flex; align-items:center; gap:10px; border-bottom:1px solid #f9f9f9; {{ !$notif->is_read ? 'background:#fffbf0;' : '' }}">
                    <div style="width:34px; height:34px; border-radius:50%; background:{{ $iconBg }}; color:{{ $iconColor }}; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <ion-icon name="{{ $iconName }}" style="font-size:16px;"></ion-icon>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="font-size:12px; font-weight:600; color:#222; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $notif->judul }}</div>
                        <div style="font-size:11px; color:#aaa; margin-top:1px;">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <div style="padding:25px; text-align:center; color:#aaa; font-size:13px;">
                    Belum ada notifikasi
                </div>
            @endforelse
        </div>
    </div>
</div>
@endpush

{{-- ✅ SIDEBAR KHUSUS APOTEKER --}}
@section('sidebar')
<div class="navigation">
    <ul>
        <li class="logo-item">
            <a href="/dashboard-apoteker">
                <span class="icon"><img src="{{ asset('images/logosimora2.png') }}" class="logo-img" alt="Logo"></span>
                <h2 class="title">SI-MORA</h2>
            </a>
        </li>
        <li>
            <a href="/dashboard-apoteker">
                <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                <span class="title">Beranda</span>
            </a>
        </li>
        <li>
            <a href="/apoteker/resep">
                <span class="icon"><ion-icon name="receipt-outline"></ion-icon></span>
                <span class="title">Data Resep</span>
            </a>
        </li>
        <li>
            <a href="/apoteker/obat">
                <span class="icon"><i class="bi bi-capsule"></i></span>
                <span class="title">Stok Obat</span>
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

{{-- ✅ KONTEN UTAMA BERANDA APOTEKER --}}
@section('content')
<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers">{{ $resepMasuk ?? 0 }}</div>
            <div class="cardName">Resep Masuk</div>
        </div>
        <div class="iconBx"><ion-icon name="mail-open-outline"></ion-icon></div>
    </div>
    <div class="card">
        <div>
            <div class="numbers">{{ $resepDiproses ?? 0 }}</div>
            <div class="cardName">Resep Diproses</div>
        </div>
        <div class="iconBx"><ion-icon name="cube-outline"></ion-icon></div>
    </div>
    <div class="card">
        <div>
            <div class="numbers">{{ $resepSelesai ?? 0 }}</div>
            <div class="cardName">Resep Selesai</div>
        </div>
        <div class="iconBx"><ion-icon name="time-outline"></ion-icon></div>
    </div>
</div>

<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Daftar Resep Hari Ini</h2>
            <a href="/apoteker/resep" class="btn-view">Lihat Semua</a>
        </div>
        <table>
            <thead>
                <tr>
                    <td>Nama Pasien</td>
                    <td>Dokter</td>
                    <td>Obat</td>
                    <td>Dosis</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                @if(isset($reseps) && count($reseps) > 0)
                    @foreach($reseps as $resep)
                        <tr>
                            <td>{{ $resep->pasien->nama_pasien ?? 'Nama tidak ditemukan' }}</td>
                            <td>{{ $resep->nama_dokter }}</td>
                            <td>{{ $resep->nama_obat }}</td>
                            <td>{{ $resep->dosis_obat }}</td>
                            <td>
                                @php
                                    $statusClass = '';
                                    switch($resep->status) {
                                        case 'Selesai': $statusClass = 'delivered'; break;
                                        case 'Pending': $statusClass = 'pending'; break;
                                        case 'Diproses': $statusClass = 'inProgress'; break;
                                        case 'Stok Habis': $statusClass = 'return'; break;
                                        default: $statusClass = 'pending'; break;
                                    }
                                @endphp
                                <span class="status {{ $statusClass }}">{{ $resep->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">Belum ada resep yang masuk hari ini.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

{{-- ✅ SUNTIKKAN SCRIPT KHUSUS UNTUK DROPDOWN NOTIFIKASI --}}
@push('scripts')
<script>
    function toggleNotifDropdown() {
        const d = document.getElementById('notifDropdown');
        d.style.display = d.style.display === 'none' ? 'block' : 'none';
    }
    document.addEventListener('click', function(e) {
        const wrapper = document.querySelector('.notif-bell-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            document.getElementById('notifDropdown').style.display = 'none';
        }
    });
</script>
@endpush