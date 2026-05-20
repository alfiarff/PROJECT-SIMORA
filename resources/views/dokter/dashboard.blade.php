@extends('dashboard-dokter')

@section('content')
    <div class="cardBox">
        <div class="card">
            <div>
                <div class="numbers">{{ $totalPasien }}</div>
                <div class="cardName">Total Pasien</div>
            </div>
            <div class="iconBx">
                <ion-icon name="people-outline"></ion-icon>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers">{{ $resepDibuat }}</div>
                <div class="cardName">Resep Hari Ini</div>
            </div>
            <div class="iconBx">
                <ion-icon name="receipt-outline"></ion-icon>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers">{{ $pasienBelumResep }}</div>
                <div class="cardName">Belum Diberi Resep</div>
            </div>
            <div class="iconBx">
                <ion-icon name="alert-circle-outline"></ion-icon>
            </div>
        </div>
    </div>

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
                    @forelse($riwayatResep as $resep)
                    <tr>
                        <td>{{ $resep->pasien->nama_lengkap ?? $resep->pasien->nama_pasien ?? '-' }}</td>
                        <td>{{ $resep->pasien->no_rm ?? $resep->pasien->nomor_rm ?? '-' }}</td>
                        <td>{{ $resep->diagnosa }}</td>
                        <td>{{ Str::limit($resep->nama_obat, 30) }}</td>
                        <td>
                            <span class="status delivered">Selesai</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px 0; color: #999;">
                            Belum ada aktivitas resep untuk hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection