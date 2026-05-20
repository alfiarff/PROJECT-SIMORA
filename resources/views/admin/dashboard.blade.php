<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin SI-MORA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:"Poppins",sans-serif; }

        :root {
            --accent: #560b18;
            --accent-light: #75162d;
            --white: #fff;
            --gray: #f5f6fa;
            --black1: #222;
            --black2: #999;
            --sidebar-width: 280px;
            --sidebar-collapsed: 75px;
        }

        body { background: var(--gray); min-height: 100vh; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--accent);
            overflow-y: auto;
            overflow-x: hidden;
            transition: width 0.3s ease;
            z-index: 100;
            padding-bottom: 30px;
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }

        /* ===== LOGO AREA ===== */
        .logo-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 25px 0 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 10px;
            overflow: hidden;
            white-space: nowrap;
        }

        .logo-area img { 
        width: 80px; height: 80px; 
        object-fit: contain; 
        flex-shrink: 0;
        }

        .logo-area h2 {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin-top: 8px;
            letter-spacing: 1px;
            transition: opacity 0.2s, max-height 0.3s;
            opacity: 1;
            max-height: 40px;
            overflow: hidden;
        }

        /* ===== NAV GROUP LABEL ===== */
        .nav-group-label {
            color: rgba(255,255,255,0.4);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 15px 20px 5px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s, max-height 0.3s, padding 0.3s;
            max-height: 40px;
            opacity: 1;
        }

        /* ===== NAV ITEM ===== */
        .nav-item {
            position: relative;
            list-style: none;
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
            margin: 2px 0;
            transition: border-radius 0.3s;
        }

        .nav-item a, .nav-item button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: gap 0.3s, padding 0.3s, justify-content 0.3s;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-item a ion-icon,
        .nav-item button ion-icon,
        .nav-item a i,
        .nav-item button i {
            font-size: 20px;
            min-width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-label {
            transition: opacity 0.2s;
            opacity: 1;
            overflow: hidden;
            white-space: nowrap;
        }

        .nav-item:hover { background: rgba(255,255,255,0.1); }

        .nav-item.active { background: var(--white); }
        .nav-item.active a,
        .nav-item.active button { color: var(--accent); }

        .nav-item.active a::before {
            content: "";
            position: absolute;
            right: 0; top: -50px;
            width: 50px; height: 50px;
            background: transparent;
            border-radius: 50%;
            box-shadow: 35px 35px 0 10px var(--white);
            pointer-events: none;
            z-index: 1;
        }

        .nav-item.active a::after {
            content: "";
            position: absolute;
            right: 0; bottom: -50px;
            width: 50px; height: 50px;
            background: transparent;
            border-radius: 50%;
            box-shadow: 35px -35px 0 10px var(--white);
            pointer-events: none;
            z-index: 1;
        }

        /* ===== SIDEBAR COLLAPSED STATE ===== */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar.collapsed .logo-area h2 {
            opacity: 0;
            max-height: 0;
            margin-top: 0;
        }

        .sidebar.collapsed .nav-group-label {
            opacity: 0;
            max-height: 0;
            padding: 0;
        }

        .sidebar.collapsed .nav-label {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed ul {
            padding: 0 8px !important;
        }

        .sidebar.collapsed .nav-item {
            border-radius: 12px;
            margin: 4px 0;
        }

        .sidebar.collapsed .nav-item a,
        .sidebar.collapsed .nav-item button {
            justify-content: center;
            padding: 14px 0;
            gap: 0;
        }

        /* Matikan efek kurva saat collapsed */
        .sidebar.collapsed .nav-item.active a::before,
        .sidebar.collapsed .nav-item.active a::after {
            display: none;
        }

        .sidebar.collapsed .nav-item.active {
            background: rgba(255,255,255,0.2);
        }

        .sidebar.collapsed .nav-item.active a,
        .sidebar.collapsed .nav-item.active button {
            color: #fff;
        }

        /* Tooltip saat collapsed */
        .sidebar.collapsed .nav-item {
            position: relative;
        }

        .sidebar.collapsed .nav-item:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(var(--sidebar-collapsed) - 8px);
            top: 50%;
            transform: translateY(-50%);
            background: #333;
            color: #fff;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 999;
            pointer-events: none;
        }

        /* ===== MAIN CONTENT ===== */
        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: var(--white);
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .topbar-left { display: flex; align-items: center; gap: 15px; }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--black1);
            display: flex;
            align-items: center;
            padding: 5px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .toggle-btn:hover { background: #f5f5f5; }

        .topbar-title { font-size: 18px; font-weight: 600; color: var(--black1); }

        .topbar-right { display: flex; align-items: center; gap: 15px; }

        .user-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .user-info { text-align: right; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--black1); display: block; }
        .user-role { font-size: 11px; color: var(--accent-light); text-transform: capitalize; }

        .user-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; font-weight: 700;
            overflow: hidden;
        }

        .user-avatar img { width: 100%; height: 100%; object-fit: cover; }

        /* ===== PAGE CONTENT ===== */
        .page-content { padding: 25px; }

        .page-header { margin-bottom: 25px; }
        .page-header h1 { font-size: 24px; font-weight: 700; color: var(--black1); }
        .page-header p { color: var(--black2); font-size: 14px; margin-top: 3px; }

        /* ===== STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }

        .stat-icon {
            width: 55px; height: 55px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
        }

        .stat-icon.purple { background: #f0ebff; color: #7c3aed; }
        .stat-icon.green  { background: #e8f8f0; color: #16a34a; }
        .stat-icon.blue   { background: #e8f4fd; color: #2563eb; }
        .stat-icon.red    { background: #fef2f2; color: #dc2626; }

        .stat-info .stat-number { font-size: 28px; font-weight: 700; color: var(--black1); line-height: 1; }
        .stat-info .stat-label  { font-size: 13px; color: var(--black2); margin-top: 4px; }

        /* ===== ROLE CARDS ===== */
        .role-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .role-card {
            background: var(--white);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-top: 4px solid;
            transition: 0.3s;
        }

        .role-card:hover { transform: translateY(-2px); }

        .role-card.admin    { border-color: #7c3aed; }
        .role-card.dokter   { border-color: #2563eb; }
        .role-card.apoteker { border-color: #16a34a; }
        .role-card.pmik     { border-color: #ea580c; }

        .role-card .role-count { font-size: 32px; font-weight: 700; color: var(--black1); }
        .role-card .role-name  { font-size: 13px; color: var(--black2); margin-top: 4px; }

        /* ===== TABLE ===== */
        .table-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 25px;
        }

        .table-card-header {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .table-card-header h3 { font-size: 16px; font-weight: 600; color: var(--black1); }

        .search-input {
            padding: 8px 16px;
            border: 1px solid #eee;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            width: 220px;
            font-family: "Poppins", sans-serif;
            transition: border-color 0.2s;
        }

        .search-input:focus { border-color: var(--accent); }

        .table-admin { width: 100%; border-collapse: collapse; }

        .table-admin th {
            background: #fafafa;
            padding: 14px 20px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: var(--black2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #f0f0f0;
        }

        .table-admin td {
            padding: 15px 20px;
            border-bottom: 1px solid #f9f9f9;
            font-size: 13px;
            color: var(--black1);
            vertical-align: middle;
        }

        .table-admin tr:last-child td { border-bottom: none; }
        .table-admin tr:hover td { background: #fdf5f6; }

        .user-avatar-sm {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700;
            overflow: hidden;
            margin-right: 10px;
            vertical-align: middle;
            flex-shrink: 0;
        }

        .user-avatar-sm img { width: 100%; height: 100%; object-fit: cover; }

        .badge-role {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-admin    { background:#f0ebff; color:#7c3aed; }
        .badge-dokter   { background:#e8f4fd; color:#2563eb; }
        .badge-apoteker { background:#e8f8f0; color:#16a34a; }
        .badge-pmik     { background:#fff7ed; color:#ea580c; }

        .badge-online  { background:#e8f8f0; color:#16a34a; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap; display:inline-block; }
        .badge-offline { background:#f5f5f5;  color:#999;    padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap; display:inline-block; }

        .btn-sm {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
            font-family: "Poppins", sans-serif;
            transition: 0.2s;
            white-space: nowrap;
        }

        .btn-role   { background:#e8f4fd; color:#2563eb; }
        .btn-role:hover { background:#2563eb; color:#fff; }
        .btn-reset  { background:#fff7ed; color:#ea580c; }
        .btn-reset:hover { background:#ea580c; color:#fff; }
        .btn-delete { background:#fef2f2; color:#dc2626; }
        .btn-delete:hover { background:#dc2626; color:#fff; }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .modal-box {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            width: 420px;
            max-width: 90vw;
            animation: fadeInUp 0.3s ease;
            position: relative;
        }

        .modal-box h3 { font-size: 18px; font-weight: 700; color: var(--black1); margin-bottom: 20px; }

        .modal-close {
            position: absolute;
            top: 15px; right: 20px;
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #999;
        }

        .modal-close:hover { color: #333; }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; font-weight: 500; color: #555; margin-bottom: 6px; }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            font-family: "Poppins", sans-serif;
            transition: 0.2s;
        }

        .form-control:focus { border-color: var(--accent); }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: "Poppins", sans-serif;
            transition: 0.2s;
            margin-top: 5px;
        }

        .btn-primary:hover { background: #3d0812; }

        .alert-success {
            background: #d4edda; color: #155724;
            padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;
        }

        .alert-error {
            background: #fef2f2; color: #7f1d1d;
            padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;
        }

        @keyframes fadeInUp {
            from { transform: translateY(20px); opacity: 0; }
            to   { transform: translateY(0); opacity: 1; }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .role-grid  { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
                transition: left 0.3s ease, width 0.3s ease;
            }
            .sidebar.mobile-open {
                left: 0;
            }
            .main { margin-left: 0 !important; }
            .stats-grid { grid-template-columns: 1fr; }
            .role-grid  { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

{{-- ===== SIDEBAR ===== --}}
<div class="sidebar" id="sidebar">
    <div class="logo-area">
        <img src="{{ asset('images/logosimora.png') }}" alt="Logo">
        <h2>SI-MORA</h2>
    </div>

    <ul style="list-style:none; padding: 0 15px;" id="navList">

        {{-- ADMIN --}}
        <div class="nav-group-label">Admin</div>

        <li class="nav-item active" data-tooltip="Beranda">
            <a href="{{ route('admin.dashboard') }}">
                <ion-icon name="home-outline"></ion-icon>
                <span class="nav-label">Beranda</span>
            </a>
        </li>

        {{-- PMIK --}}
        <div class="nav-group-label">PMIK</div>

        <li class="nav-item" data-tooltip="Data Pasien">
            <a href="/pasien">
                <ion-icon name="people-outline"></ion-icon>
                <span class="nav-label">Data Pasien</span>
            </a>
        </li>

        <li class="nav-item" data-tooltip="Tambah Pasien">
            <a href="/pasien/create">
                <ion-icon name="person-add-outline"></ion-icon>
                <span class="nav-label">Tambah Pasien</span>
            </a>
        </li>

        {{-- DOKTER --}}
        <div class="nav-group-label">Dokter</div>

        <li class="nav-item" data-tooltip="Tambah Resep">
            <a href="/resep/create">
                <ion-icon name="create-outline"></ion-icon>
                <span class="nav-label">Tambah Resep</span>
            </a>
        </li>

        <li class="nav-item" data-tooltip="Data Resep">
            <a href="/resep">
                <ion-icon name="document-text-outline"></ion-icon>
                <span class="nav-label">Data Resep</span>
            </a>
        </li>

        {{-- APOTEKER --}}
        <div class="nav-group-label">Apoteker</div>

        <li class="nav-item" data-tooltip="Resep Masuk">
            <a href="/apoteker/resep">
                <ion-icon name="receipt-outline"></ion-icon>
                <span class="nav-label">Resep Masuk</span>
            </a>
        </li>

        <li class="nav-item" data-tooltip="Stok Obat">
            <a href="/apoteker/obat">
                <i class="bi bi-capsule"></i>
                <span class="nav-label">Stok Obat</span>
            </a>
        </li>

        {{-- AKUN --}}
        <div class="nav-group-label">Akun</div>

        <li class="nav-item" data-tooltip="Pengaturan">
            <a href="/profile">
                <ion-icon name="settings-outline"></ion-icon>
                <span class="nav-label">Pengaturan</span>
            </a>
        </li>

        <li class="nav-item" data-tooltip="Keluar">
            <button onclick="openLogoutModal()">
                <ion-icon name="log-out-outline"></ion-icon>
                <span class="nav-label">Keluar</span>
            </button>
        </li>

    </ul>
</div>

{{-- ===== MAIN ===== --}}
<div class="main" id="main">

    {{-- TOPBAR --}}
    <div class="topbar">
        <div class="topbar-left">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <ion-icon name="menu-outline"></ion-icon>
            </button>
            <span class="topbar-title">Dashboard Admin</span>
        </div>
        <div class="topbar-right">
            <div class="user-profile">
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">Administrator</span>
                </div>
                <div class="user-avatar">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="page-content">

        <div class="page-header">
            <h1>Selamat Datang, {{ Auth::user()->name }} 👋</h1>
            <p>Panel administrasi SI-MORA — kelola akun dan pantau aktivitas sistem</p>
        </div>

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">⚠️ {{ session('error') }}</div>
        @endif

        {{-- STATS --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon purple"><ion-icon name="people-outline"></ion-icon></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $totalUsers }}</div>
                    <div class="stat-label">Total Akun</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><ion-icon name="wifi-outline"></ion-icon></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $onlineUsers }}</div>
                    <div class="stat-label">Sedang Online</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><ion-icon name="person-outline"></ion-icon></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $totalPasien }}</div>
                    <div class="stat-label">Total Pasien</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red"><ion-icon name="receipt-outline"></ion-icon></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $totalResep }}</div>
                    <div class="stat-label">Total Resep</div>
                </div>
            </div>
        </div>

        {{-- ROLE BREAKDOWN --}}
        <div class="role-grid">
            <div class="role-card admin">
                <div class="role-count">{{ $roleCount['admin'] }}</div>
                <div class="role-name"> Admin</div>
            </div>
            <div class="role-card dokter">
                <div class="role-count">{{ $roleCount['dokter'] }}</div>
                <div class="role-name"> Dokter</div>
            </div>
            <div class="role-card apoteker">
                <div class="role-count">{{ $roleCount['apoteker'] }}</div>
                <div class="role-name"> Apoteker</div>
            </div>
            <div class="role-card pmik">
                <div class="role-count">{{ $roleCount['pmik'] }}</div>
                <div class="role-name"> PMIK</div>
            </div>
        </div>

        {{-- TABEL AKUN --}}
        <div class="table-card">
            <div class="table-card-header">
                <h3>Daftar Akun Pengguna</h3>
                <input type="text" id="searchUser" class="search-input" placeholder="Cari nama / email...">
            </div>
            <table class="table-admin" id="userTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Terakhir Online</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div style="display:flex; align-items:center;">
                                <div class="user-avatar-sm">
                                    @if($user->foto)
                                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto">
                                    @else
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    @endif
                                </div>
                                <span style="font-weight:500;">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td style="color:#666;">{{ $user->email }}</td>
                        <td>
                            <span class="badge-role badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>
                            @if($user->isOnline())
                                <span class="badge-online">● Online</span>
                            @else
                                <span class="badge-offline">● Offline</span>
                            @endif
                        </td>
                        <td style="color:#888; font-size:12px; white-space:nowrap;">
                            {{ $user->last_seen ? $user->last_seen->diffForHumans() : 'Belum pernah login' }}
                        </td>
                        <td>
                            <button onclick="openRoleModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->role }}')"
                                class="btn-sm btn-role">
                                <i class="bi bi-shield"></i> Role
                            </button>

                            <button onclick="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                class="btn-sm btn-reset">
                                <i class="bi bi-key"></i> Reset
                            </button>

                            @if($user->id !== Auth::id())
                                <a href="{{ route('admin.user.delete', $user->id) }}"
                                    onclick="return confirm('Yakin hapus akun {{ addslashes($user->name) }}?')"
                                    class="btn-sm btn-delete">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:30px; color:#888;">
                            Belum ada akun terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- ===== MODAL UBAH ROLE ===== --}}
<div class="modal-overlay" id="roleModal">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('roleModal')">&times;</button>
        <h3>Ubah Role Pengguna</h3>
        <p style="font-size:13px; color:#666; margin-bottom:20px;">
            Mengubah role: <strong id="roleUserName"></strong>
        </p>
        <form method="POST" id="roleForm">
            @csrf
            <div class="form-group">
                <label>Pilih Role Baru</label>
                <select name="role" class="form-control" id="roleSelect">
                    <option value="admin"> Admin</option>
                    <option value="dokter"> Dokter</option>
                    <option value="apoteker"> Apoteker</option>
                    <option value="pmik"> PMIK</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>

{{-- ===== MODAL RESET PASSWORD ===== --}}
<div class="modal-overlay" id="resetModal">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('resetModal')">&times;</button>
        <h3>Reset Password</h3>
        <p style="font-size:13px; color:#666; margin-bottom:20px;">
            Reset password untuk: <strong id="resetUserName"></strong>
        </p>
        <form method="POST" id="resetForm">
            @csrf
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="new_password" class="form-control"
                       placeholder="Minimal 6 karakter" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="new_password_confirmation" class="form-control"
                       placeholder="Ulangi password baru" required>
            </div>
            <button type="submit" class="btn-primary">Reset Password</button>
        </form>
    </div>
</div>

{{-- ===== MODAL LOGOUT ===== --}}
<div id="logoutModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; padding:40px; width:500px; max-width:90vw; text-align:center; animation:fadeInUp 0.3s ease;">
        <div style="width:64px; height:64px; background:#fef2f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <ion-icon name="warning-outline" style="font-size:32px; color:#7f1d1d;"></ion-icon>
        </div>
        <h3 style="margin:0 0 8px; color:#7f1d1d;">Konfirmasi Logout</h3>
        <p style="color:#555; margin-bottom:24px;">Apakah kamu yakin ingin keluar dari sistem?</p>
        <div style="display:flex; gap:12px; justify-content:center;">
            <button onclick="closeLogoutModal()" type="button"
                style="padding:10px 24px; border-radius:8px; border:1px solid #ccc; background:#fff; cursor:pointer; font-family:inherit;">
                Batal
            </button>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit"
                    style="padding:10px 24px; border-radius:8px; background:#7f1d1d; color:#fff; border:none; cursor:pointer; font-family:inherit;">
                    Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // ===== TOGGLE SIDEBAR =====
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main    = document.getElementById('main');
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
    }

    // ===== SEARCH USER =====
    document.getElementById('searchUser').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('#userTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    // ===== MODAL ROLE =====
    function openRoleModal(id, name, currentRole) {
        document.getElementById('roleUserName').textContent = name;
        document.getElementById('roleForm').action = `/admin/user/${id}/role`;
        document.getElementById('roleSelect').value = currentRole;
        document.getElementById('roleModal').style.display = 'flex';
    }

    // ===== MODAL RESET PASSWORD =====
    function openResetModal(id, name) {
        document.getElementById('resetUserName').textContent = name;
        document.getElementById('resetForm').action = `/admin/user/${id}/reset-password`;
        document.getElementById('resetModal').style.display = 'flex';
    }

    // ===== TUTUP MODAL =====
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // Klik luar modal = tutup
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });
    });

    // ===== LOGOUT MODAL =====
    function openLogoutModal() {
        document.getElementById('logoutModal').style.display = 'flex';
    }
    function closeLogoutModal() {
        document.getElementById('logoutModal').style.display = 'none';
    }
    document.getElementById('logoutModal').addEventListener('click', function(e) {
        if (e.target === this) closeLogoutModal();
    });
</script>

</body>
</html>