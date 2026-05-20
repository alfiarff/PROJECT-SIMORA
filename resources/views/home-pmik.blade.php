@extends('dashboard-pmik') 

@section('content')
<style>
    /* Kembalikan menjadi 2 kolom agar memenuhi layar */
    .cardBox {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 30px;
    }

    /* KUNCI UTAMA: Samakan tinggi dan tata letak persis seperti Dashboard Dokter */
    .cardBox .card {
        display: flex !important;
        flex-direction: row !important;
        justify-content: space-between !important;
        align-items: center !important;
        height: 140px !important; /* Mengunci tinggi card agar tidak melar */
        background: #ffffff !important;
        padding: 30px !important;
        border-radius: 20px;
        box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08) !important;
        border: none !important;
    }

    /* Menyesuaikan ukuran font dan warna agar identik */
    .cardBox .card .numbers {
        font-size: 2.5rem !important;
        font-weight: 500 !important;
        color: #111 !important;
    }

    .cardBox .card .cardName {
        color: #999 !important;
        font-size: 1.1rem !important;
        margin-top: 5px;
    }

    .cardBox .card .iconBx {
        font-size: 3.5rem !important;
        color: #999 !important; 
    }
</style>

<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers">{{ $totalPasien ?? 0 }}</div>
            <div class="cardName">Total Pasien</div>
        </div>
        <div class="iconBx">
            <ion-icon name="people-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers">{{ $pasienHariIni ?? 0 }}</div>
            <div class="cardName">Pasien Baru Hari Ini</div>
        </div>
        <div class="iconBx">
            <ion-icon name="person-add-outline"></ion-icon>
        </div>
    </div>
</div>

<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Data Pasien Terbaru</h2>
            <a href="/pasien" class="btn-view">Lihat Semua</a>
        </div>
        <table>
            <thead>
                <tr>
                    <td>Nama</td>
                    <td>No RM</td>
                    <td>Jenis Kelamin</td>
                    <td>Usia</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                @forelse($pasienTerbaru as $p)
                <tr>
                    <td>{{ $p->nama_pasien }}</td>
                    <td>{{ $p->nomor_rm }}</td> 
                    <td>{{ $p->jenis_kelamin }}</td>
                    <td>{{ $p->usia }} Tahun</td>
                    <td><span class="status delivered">Aktif</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada data pasien.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection