<style>
    /* ===== SIDEBAR ADMIN - FULL OVERRIDE ===== */

    .navigation {
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }

    /* ul ikut alur dokumen bukan absolute */
    .navigation ul {
        position: relative !important;
        top: auto !important;
        left: auto !important;
        width: 100% !important;
        padding-top: 0 !important;
    }

    /* ===== LOGO ===== */
.navigation ul li.logo-item {
    pointer-events: none !important;
    height: auto !important;
    min-height: 150px !important;
    margin-bottom: 30px !important;
    background: transparent !important;
}

.navigation ul li.logo-item a {
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    align-items: center !important;
    height: 150px !important;
    min-height: 150px !important;
    padding: 20px 0 !important;
}

.navigation ul li.logo-item a img,
.navigation ul li.logo-item a .logo-img,
.navigation ul li.logo-item .icon img {
    width: 80px !important;
    height: 80px !important;
    min-width: 80px !important;
    min-height: 80px !important;
    object-fit: contain !important;
    margin-bottom: 8px !important;
    display: block !important;
}

.navigation ul li.logo-item .title {
    color: #fff !important;
    font-size: 20px !important;
    font-weight: 600 !important;
    letter-spacing: 1px !important;
    margin: 0 !important;
    display: block !important;
    height: auto !important;
    line-height: normal !important;
    padding: 0 !important;
    position: static !important;
    white-space: nowrap !important;
    text-align: center !important;
}

.navigation ul li.logo-item .icon {
    min-width: auto !important;
    height: auto !important;
    display: block !important;
}

.navigation ul li.logo-item a::before,
.navigation ul li.logo-item a::after {
    display: none !important;
    box-shadow: none !important;
}

.navigation ul li.logo-item:hover,
.navigation ul li.logo-item.hovered {
    background: transparent !important;
}

.navigation ul li.logo-item.hovered::before,
.navigation ul li.logo-item.hovered::after {
    display: none !important;
}

    /* ===== DROPDOWN CONTAINER ===== */
    .navigation ul li.has-dropdown {
        height: auto !important;
        overflow: visible !important;
    }

    .navigation ul li.has-dropdown > a {
        height: 60px !important;
        min-height: 60px !important;
        position: relative !important;
    }

    /* ===== OVERRIDE BOOTSTRAP DROPDOWN ===== */
    .navigation ul li .dropdown-menu {
        position: relative !important;
        display: none !important;
        float: none !important;
        background: rgba(0,0,0,0.2) !important;
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        min-width: unset !important;
        width: 100% !important;
        inset: unset !important;
        transform: none !important;
        z-index: 1 !important;
    }

    .navigation ul li .dropdown-menu.show {
        display: block !important;
    }

    /* ===== ITEM DALAM DROPDOWN ===== */
    .navigation ul li .dropdown-menu li {
        height: 50px !important;
        min-height: 50px !important;
        width: 100% !important;
        border-radius: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
    }

    .navigation ul li .dropdown-menu li a {
        height: 50px !important;
        width: 100% !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 15px !important;
        color: rgba(255,255,255,0.85) !important;
        text-decoration: none !important;
        position: relative !important;
    }

    .navigation ul li .dropdown-menu li a .icon {
        min-width: 50px !important;
        height: 50px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 20px !important;
    }

    .navigation ul li .dropdown-menu li a .title {
        height: 50px !important;
        line-height: 50px !important;
        font-size: 13px !important;
        padding: 0 10px !important;
        position: static !important;
    }

    .navigation ul li .dropdown-menu li a:hover {
        background: rgba(255,255,255,0.1) !important;
        color: #fff !important;
    }

    .navigation ul li .dropdown-menu li a::before,
    .navigation ul li .dropdown-menu li a::after {
        display: none !important;
        box-shadow: none !important;
    }

    .navigation ul li .dropdown-menu li:hover,
    .navigation ul li .dropdown-menu li.hovered {
        background: rgba(255,255,255,0.1) !important;
    }

    .navigation ul li .dropdown-menu li.hovered::before,
    .navigation ul li .dropdown-menu li.hovered::after {
        display: none !important;
    }

    /* ===== PANAH CHEVRON ===== */
    .arrow-icon {
        position: absolute;
        right: 25px;
        top: 50%;
        transform: translateY(-50%);
        transition: transform 0.3s ease;
        font-size: 18px;
        color: rgba(255,255,255,0.8);
        pointer-events: none;
    }

    .has-dropdown.open .arrow-icon {
        transform: translateY(-50%) rotate(180deg);
    }
</style>

<div class="navigation">
    <ul>
        {{-- LOGO --}}
        <li class="logo-item">
            <a href="{{ route('admin.dashboard') }}">
                <span class="icon">
                    <img src="{{ asset('images/logosimora.png') }}" alt="Logo SI-MORA">
                </span>
                <span class="title">SI-MORA</span>
            </a>
        </li>

        {{-- BERANDA --}}
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                <span class="title">Beranda Admin</span>
            </a>
        </li>

        {{-- DROPDOWN: MENU PMIK --}}
        <li class="has-dropdown" id="dd-pmik">
            <a href="#" onclick="toggleMenu(event, 'pmik')">
                <span class="icon"><ion-icon name="folder-outline"></ion-icon></span>
                <span class="title">Menu PMIK</span>
                <span class="arrow-icon">
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </span>
            </a>
            <ul class="dropdown-menu" id="menu-pmik">
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
            </ul>
        </li>

        {{-- DROPDOWN: MENU DOKTER --}}
        <li class="has-dropdown" id="dd-dokter">
            <a href="#" onclick="toggleMenu(event, 'dokter')">
                <span class="icon"><ion-icon name="medkit-outline"></ion-icon></span>
                <span class="title">Menu Dokter</span>
                <span class="arrow-icon">
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </span>
            </a>
            <ul class="dropdown-menu" id="menu-dokter">
                <li>
                    <a href="/resep">
                        <span class="icon"><ion-icon name="document-text-outline"></ion-icon></span>
                        <span class="title">Data Resep</span>
                    </a>
                </li>
                <li>
                    <a href="/resep/create">
                        <span class="icon"><ion-icon name="create-outline"></ion-icon></span>
                        <span class="title">Tambah Resep</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- DROPDOWN: MENU APOTEKER --}}
        <li class="has-dropdown" id="dd-apoteker">
            <a href="#" onclick="toggleMenu(event, 'apoteker')">
                <span class="icon"><ion-icon name="flask-outline"></ion-icon></span>
                <span class="title">Menu Apoteker</span>
                <span class="arrow-icon">
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </span>
            </a>
            <ul class="dropdown-menu" id="menu-apoteker">
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
            </ul>
        </li>

        {{-- PENGATURAN --}}
        <li>
            <a href="/profile">
                <span class="icon"><ion-icon name="settings-outline"></ion-icon></span>
                <span class="title">Pengaturan</span>
            </a>
        </li>

        {{-- KELUAR --}}
        <li>
            <a href="#" onclick="event.preventDefault(); openLogoutModal();">
                <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                <span class="title">Keluar</span>
            </a>
        </li>
    </ul>
</div>

<script>
    function toggleMenu(event, id) {
        event.preventDefault();

        const parent = document.getElementById('dd-' + id);
        const menu   = document.getElementById('menu-' + id);
        const isOpen = menu.classList.contains('show');

        document.querySelectorAll('.navigation .dropdown-menu').forEach(el => {
            el.classList.remove('show');
        });
        document.querySelectorAll('.navigation .has-dropdown').forEach(el => {
            el.classList.remove('open');
        });

        if (!isOpen) {
            menu.classList.add('show');
            parent.classList.add('open');
        }
    }
</script>