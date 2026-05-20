<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard SI-MORA</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <div class="navigation">
        <ul>

            <li class="logo-item">
                <a href="/dashboard">
                    <span class="icon">
                        <img src="{{ asset('images/logosimora.png') }}" class="logo-img" alt="Logo SI-MORA">
                    </span>
                    <h2 class="title">SI-MORA</h2>
                </a>
            </li>

            <li>
                <a href="/dashboard">
                    <span class="icon">
                        <ion-icon name="home-outline"></ion-icon>
                    </span>
                    <span class="title">Beranda</span>
                </a>
            </li>

            <li>
                <a href="/pasien">
                    <span class="icon">
                        <ion-icon name="people-outline"></ion-icon>
                    </span>
                    <span class="title">Data Pasien</span>
                </a>
            </li>

            <li>
                <a href="/pasien/create">
                    <span class="icon">
                        <ion-icon name="person-add-outline"></ion-icon>
                    </span>
                    <span class="title">Tambah Pasien</span>
                </a>
            </li>

            <li>
                <a href="/resep/create">
                    <span class="icon">
                        <ion-icon name="receipt-outline"></ion-icon>
                    </span>
                    <span class="title">Tambah Resep</span>
                </a>
            </li>

            <li>
                <a href="/resep">
                    <span class="icon">
                        <ion-icon name="document-text-outline"></ion-icon>
                    </span>
                    <span class="title">Data Resep</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <span class="icon">
                        <i class="bi bi-capsule"></i>
                    </span>
                    <span class="title">Halaman Obat</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <span class="icon">
                        <ion-icon name="notifications-outline"></ion-icon>
                    </span>
                    <span class="title">Notifikasi</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <span class="icon">
                        <ion-icon name="settings-outline"></ion-icon>
                    </span>
                    <span class="title">Pengaturan</span>
                </a>
            </li>

            <li>
             <a href="#" onclick="event.preventDefault(); openLogoutModal();">
            <span class="icon">
            <ion-icon name="log-out-outline"></ion-icon>
            </span>
            <span class="title">Keluar</span>
            </a>
            </li>
        </ul>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Topbar -->
        <div class="topbar">

            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>

            <div class="search">
                <label>
                    <input type="text" placeholder="Search here">
                    <ion-icon name="search-outline"></ion-icon>
                </label>
            </div>

            <div class="user">
                <img src="{{ asset('images/logo.png') }}" alt="User">
            </div>

        </div>

        <!-- Cards -->
        <div class="cardBox">

            <div class="card">
                <div>
                    <div class="numbers">20</div>
                    <div class="cardName">Resep Dalam Proses</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">80</div>
                    <div class="cardName">Obat Keluar Hari Ini</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="cart-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">43</div>
                    <div class="cardName">Resep Keluar Hari Ini</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="receipt-outline"></ion-icon>
                </div>
            </div>

        </div>

        <!-- Riwayat -->
        <div class="details">

            <div class="recentOrders">

                <div class="cardHeader">
                    <h2>Riwayat Order Hari Ini</h2>
                    <a href="/resep" class="btn-view">View All</a>
                </div>

                <table>

                    <thead>
                        <tr>
                            <td>Nama</td>
                            <td>Nomor RM</td>
                            <td>Diagnosa</td>
                            <td>Obat</td>
                            <td>Kode Obat</td>
                            <td>Dokter</td>
                            <td>Status</td>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>Meysila Febiana Putri</td>
                            <td>142345</td>
                            <td>Hipertensi Primer</td>
                            <td>Amlodipine 5 mg</td>
                            <td>AMLO-5-TAB</td>
                            <td>dr. Rendra</td>
                            <td><span class="status delivered">Delivered</span></td>
                        </tr>

                        <tr>
                            <td>Alfiatul Rofiah</td>
                            <td>142346</td>
                            <td>Gastritis Akut</td>
                            <td>Omeprazole 20 mg</td>
                            <td>OMEP-20-CAP</td>
                            <td>dr. Intan</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>

                        <tr>
                            <td>Dibsha Silvia</td>
                            <td>142347</td>
                            <td>Diabetes Mellitus</td>
                            <td>Metformin 500 mg</td>
                            <td>METF-500-TAB</td>
                            <td>dr. Bima</td>
                            <td><span class="status return">Return</span></td>
                        </tr>

                        <tr>
                            <td>Nadhif Aji</td>
                            <td>142348</td>
                            <td>Anemia</td>
                            <td>Ferrous Sulfate</td>
                            <td>FERS-325</td>
                            <td>dr. Nadia</td>
                            <td><span class="status inProgress">In Progress</span></td>
                        </tr>

                        <tr>
                            <td>Naimatul Kamilah</td>
                            <td>142349</td>
                            <td>Dermatitis</td>
                            <td>Cetirizine</td>
                            <td>CETI-10</td>
                            <td>dr. Yoga</td>
                            <td><span class="status delivered">Delivered</span></td>
                        </tr>

                        <tr>
                            <td>Favian Sanjia</td>
                            <td>142350</td>
                            <td>Diabetes Tipe 2</td>
                            <td>Metformin</td>
                            <td>MET-500</td>
                            <td>dr. Keanu</td>
                            <td><span class="status inProgress">In Progress</span></td>
                        </tr>

                        <tr>
                            <td>Calista Aurellia</td>
                            <td>142351</td>
                            <td>Asma Bronkial</td>
                            <td>Salbutamol</td>
                            <td>SAL-INH</td>
                            <td>dr. Vano</td>
                            <td><span class="status delivered">Delivered</span></td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="{{ asset('js/dashboard.js') }}"></script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

{{-- ✅ Modal Konfirmasi Logout --}}
<div id="logoutModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; padding:32px; width:360px; text-align:center; animation:fadeInUp 0.3s ease;">
        <div style="font-size:48px; margin-bottom:12px;">🚪</div>
        <h3 style="margin:0 0 8px; color:#7f1d1d;">Konfirmasi Logout</h3>
        <p style="color:#555; margin-bottom:24px;">Apakah kamu yakin ingin keluar dari sistem?</p>
        <div style="display:flex; gap:12px; justify-content:center;">
            <button onclick="closeLogoutModal()" type="button"
                style="padding:10px 24px; border-radius:8px; border:1px solid #ccc; background:#fff; cursor:pointer;">
                Batal
            </button>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit"
                    style="padding:10px 24px; border-radius:8px; background:#7f1d1d; color:#fff; border:none; cursor:pointer;">
                    Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from { transform: translateY(30px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}
</style>

<script>
function openLogoutModal() {
    const m = document.getElementById('logoutModal');
    m.style.display = 'flex';
}
function closeLogoutModal() {
    const m = document.getElementById('logoutModal');
    m.style.display = 'none';
}
document.getElementById('logoutModal').addEventListener('click', function(e) {
    if (e.target === this) closeLogoutModal();
});
</script>

</body>
</html>
