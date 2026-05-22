<!-- resources/views/layouts/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-MORA | @yield('title', 'Dashboard')</title>

    <!-- BOOTSTRAP (Kita pasang di semua halaman agar seragam) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- FONT POPPINS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Gabungan (Satukan semua style dari 3 file sebelumnya di sini) -->
    <style>
        * { font-family: 'Poppins', sans-serif; }
        
        /* Reset Container Bootstrap agar tidak mengganggu layout custom kamu */
        .container-fluid { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
        a { text-decoration: none; }
        .navigation ul { padding-left: 0 !important; margin-bottom: 0 !important; }

        /* Topbar & Search */
        .topbar { display: flex; align-items: center; justify-content: space-between; padding: 15px 30px; gap: 20px; }
        .toggle { cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .toggle ion-icon { font-size: 40px; }
        
        .search { flex: 1; max-width: 500px; position: relative; }
        .search label { width: 100%; display: block; position: relative; }
        .search label input {
            width: 100%; height: 45px; border-radius: 40px;
            padding: 5px 20px 5px 45px; border: 1px solid #ccc; outline: none;
        }
        .search label ion-icon { position: absolute; top: 50%; left: 15px; transform: translateY(-50%); font-size: 20px; color: #555; }

        /* User Profile Gabungan */
        .user-profile { display: flex; align-items: center; gap: 15px; cursor: pointer; }
        .user-info { display: flex; flex-direction: column; text-align: right; }
        .user-info .user-name { font-weight: 600; color: #333; font-size: 15px; line-height: 1.2; }
        .user-info .user-role { font-size: 12px; color: #75162d; text-transform: capitalize; }
        .user-avatar { width: 45px; height: 45px; border-radius: 50%; background-color: #75162d; color: white; display: flex; justify-content: center; align-items: center; font-size: 20px; font-weight: bold; overflow: hidden; }
        .user-avatar img { width: 100%; height: 100%; object-fit: cover; }

        /* Modal Layout */
        @keyframes fadeInUp {
            from { transform: translateY(30px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }

        /* Area Konten Dinamis */
        .main-content { padding: 20px; width: 100%; }

        @stack('styles')
    </style>
</head>
<body>

    @if(Auth::user()->role === 'admin')
        @include('admin.sidebar')
    @else
        <div class="container-fluid">
            <!-- Sidebar Dinamis (Akan diisi oleh masing-masing dashboard) -->
            @yield('sidebar')
            
            <div class="main">
                <!-- Topbar -->
                <div class="topbar">
                    <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>

                    @if(!View::hasSection('hide_search'))
                    <form action="@yield('search_action', '#')" method="GET" class="search">
                        <label>
                            <input type="text" name="search" placeholder="@yield('search_placeholder', 'Cari data...')" value="{{ request('search') }}">
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </form>
                    @endif

                    <div style="display:flex; align-items:center; gap:12px;">
                        <!-- Inject Notifikasi (Jika Ada) -->
                        @stack('notif-bell')

                        <!-- User Profile -->
                        <div class="user-profile">
                            <div class="user-info">
                                <span class="user-name">{{ Auth::user()->name ?? 'User' }}</span>
                                <span class="user-role">{{ Auth::user()->role ?? 'Role' }}</span>
                            </div>
                            <div class="user-avatar">
                                @if(Auth::check() && Auth::user()->foto)
                                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto Profil">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konten Utama -->
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Logout Seragam -->
    <div id="logoutModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
            <div style="background:#fff; border-radius:12px; padding:40px; width:500px; max-width:90vw; text-align:center; animation:fadeInUp 0.3s ease;">            <h3 style="margin:0 0 8px; color:#7f1d1d;">Konfirmasi Logout</h3>
            <p style="color:#555; margin-bottom:24px;">Apakah kamu yakin ingin keluar dari sistem?</p>
            <div style="display:flex; gap:12px; justify-content:center;">
                <button onclick="closeLogoutModal()" type="button" style="padding:10px 24px; border-radius:8px; border:1px solid #ccc; background:#fff; cursor:pointer;">Batal</button>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="padding:10px 24px; border-radius:8px; background:#7f1d1d; color:#fff; border:none; cursor:pointer;">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        function openLogoutModal() { document.getElementById('logoutModal').style.display = 'flex'; }
        function closeLogoutModal() { document.getElementById('logoutModal').style.display = 'none'; }
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) closeLogoutModal();
        });
    </script>
    @stack('scripts')
</body>
</html>