<div class="navigation">
    <ul>
        <li class="logo-item">
            <a href="{{ route('admin.dashboard') }}">
                <span class="icon"><img src="{{ asset('images/logosimora.png') }}" class="logo-img" alt="Logo SI-MORA"></span>
                <h2 class="title">SI-MORA</h2>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.dashboard') }}">
                <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                <span class="title">Beranda Admin</span>
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
            <a href="/apoteker/resep">
                <span class="icon"><ion-icon name="receipt-outline"></ion-icon></span>
                <span class="title">Resep Masuk</span>
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