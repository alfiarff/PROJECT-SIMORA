@extends('dashboard-dokter')

@section('content')
    <div class="cardBox">
        <div class="card">
            <div>
                <div class="numbers">18</div>
                <div class="cardName">Pasien Hari Ini</div>
            </div>
            <div class="iconBx">
                <ion-icon name="people-outline"></ion-icon>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers">10</div>
                <div class="cardName">Resep Dibuat</div>
            </div>
            <div class="iconBx">
                <ion-icon name="receipt-outline"></ion-icon>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers">4</div>
                <div class="cardName">Menunggu Resep</div>
            </div>
            <div class="iconBx">
                <ion-icon name="time-outline"></ion-icon>
            </div>
        </div>
    </div>

    <div class="details">
        <div class="recentOrders">
            <div class="cardHeader">
                <h2>Riwayat Resep Hari Ini</h2>
                <a href="/resep" class="btn-view">View All</a>
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
                    <tr>
                        <td>Meysila Febiana Putri</td>
                        <td>142345</td>
                        <td>Hipertensi</td>
                        <td>Amlodipine</td>
                        <td><span class="status delivered">Terkirim</span></td>
                    </tr>
                    <tr>
                        <td>Favian Sanjia</td>
                        <td>142346</td>
                        <td>Diabetes</td>
                        <td>Metformin</td>
                        <td><span class="status pending">Pending</span></td>
                    </tr>
                    <tr>
                        <td>Alfiatul Rofiah</td>
                        <td>142347</td>
                        <td>Gastritis</td>
                        <td>Omeprazole</td>
                        <td><span class="status inProgress">Diproses</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection