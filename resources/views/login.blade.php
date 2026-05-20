<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<title>Login SI-MORA</title>

<!-- FONT POPPINS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container" id="container">

    <!-- REGISTER -->
    <div class="form-container sign-up">
        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="form-logo">
                <img src="{{ asset('images/logosimora2.png') }}" alt="Logo">
            </div>

            <h1>Daftar</h1>

            <p class="form-subtitle">
                Daftarkan akun anda menggunakan email ke SI-MORA.
            </p>

            @if(session('register_error'))
                <div style="background:#fef2f2; border:1px solid #fca5a5; color:#7f1d1d; padding:10px 14px; border-radius:8px; margin-bottom:12px; font-size:13px; text-align:left;">
                    ⚠️ {{ session('register_error') }}
                </div>
            @endif

            <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}" required>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Kata Sandi" required>
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
            <button type="submit">Daftar</button>
        </form>
    </div>

    <!-- LOGIN -->
    <div class="form-container sign-in">
        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="form-logo">
                <img src="{{ asset('images/logosimora2.png') }}" alt="Logo">
            </div>

            <h1>Masuk</h1>

            <p class="form-subtitle">
                Masukkan email dan password anda ke SI-MORA.
            </p>

            @if(session('error'))
                <div style="background:#fef2f2; border:1px solid #fca5a5; color:#7f1d1d; padding:10px 14px; border-radius:8px; margin-bottom:12px; font-size:13px; text-align:left;">
                    ⚠️ Login gagal. Periksa kembali email dan kata sandi Anda.
                </div>
            @endif

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            <input type="password" name="password" placeholder="Kata Sandi">

            {{-- ✅ Lupa Password --}}
            <a href="#" onclick="openForgotModal()">Lupa Kata Sandi?</a>

            <button type="submit">Masuk</button>
        </form>
    </div>

    <!-- TOGGLE -->
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h2>Selamat Datang!</h2>
                <p>Masukkan nama dan password anda jika punya akun</p>
                <button type="button" class="hidden" id="login">Masuk</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h2>Selamat Datang Kembali!</h2>
                <p>Daftar jika belum punya akun</p>
                <button type="button" class="hidden" id="register">Daftar</button>
            </div>
        </div>
    </div>

</div>

{{-- Modal Lupa Password --}}
<div id="forgotModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; padding:32px; width:420px; max-width:90vw; text-align:center; animation:fadeInUp 0.3s ease;">
        <div style="width:64px; height:64px; background:#fef2f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="fa-solid fa-lock" style="font-size:28px; color:#7f1d1d;"></i>
        </div>
        <h3 style="margin:0 0 8px; color:#7f1d1d;">Lupa Kata Sandi?</h3>
        <p style="color:#666; font-size:13px; margin-bottom:20px;">Masukkan email Anda, kami akan mengirimkan link untuk mereset kata sandi.</p>

        @if(session('forgot_success'))
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:8px; margin-bottom:15px; font-size:13px;">
                ✅ {{ session('forgot_success') }}
            </div>
        @endif

        @if(session('forgot_error'))
            <div style="background:#fef2f2; border:1px solid #fca5a5; color:#7f1d1d; padding:10px; border-radius:8px; margin-bottom:15px; font-size:13px;">
                ⚠️ {{ session('forgot_error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('forgot.send') }}" style="text-align:left;">
            @csrf
            <div style="margin-bottom:20px;">
                <input type="email" name="email" placeholder="Email terdaftar" required
                    style="width:100%; padding:10px 14px; border:1px solid #ddd; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box; font-family:inherit;">
            </div>
            <div style="display:flex; gap:10px;">
                <button type="button" onclick="closeForgotModal()"
                    style="flex:1; padding:10px; border-radius:8px; border:1px solid #ccc; background:#fff; cursor:pointer; font-size:13px; font-family:inherit;">
                    Batal
                </button>
                <button type="submit"
                    style="flex:1; padding:10px; border-radius:8px; background:#7f1d1d; color:#fff; border:none; cursor:pointer; font-size:13px; font-weight:600; font-family:inherit;">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>

<style>
*{
    font-family: 'Poppins', sans-serif;
}

@keyframes fadeInUp {
    from { transform: translateY(30px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}

/* =========================
   FORM LOGO
========================= */

.form-logo{
    display:flex;
    justify-content:center;
    margin-bottom:8px;
}

.form-logo img{
    width:42px;
    height:auto;
}

/* =========================
   TITLE FORM
========================= */

.form-container h1{
    font-size:26px;
    font-weight:700;
    color:#111;
    margin-bottom:0px;
    line-height:1.1;
}

/* =========================
   SUBTITLE
========================= */

.form-subtitle{
    font-size:12px !important;
    line-height:1.6 !important;
    font-weight:400;
    color:#000;
    margin-top:0px;
    margin-bottom:14px;
    text-align:center;
    white-space:nowrap;
}

/* =========================
   INPUT
========================= */

.form-container input{
    background:#f2f2f2;
    border:none;
    padding:11px 14px;
    border-radius:6px;
    font-size:12px;
    margin:6px 0;
}

.form-container input::placeholder{
    color:#b0b0b0;
}

/* =========================
   BUTTON
========================= */

.form-container button{
    margin-top:12px;
    padding:10px 40px;
    border-radius:6px;
    font-size:11px;
    font-weight:600;
    letter-spacing:1px;
}

/* =========================
   TOGGLE TEXT
========================= */

.toggle-panel h2{
    font-size:24px;
    font-weight:700;
    margin-bottom:10px;
}

.toggle-panel p{
    font-size:12px;
    line-height:1.6;
    width:80%;
    text-align:center;
}

/* =========================
   CONTAINER
========================= */

.container{
    border-radius:18px;
    overflow:hidden;
}

/* =========================
   CARD SHADOW
========================= */

.container{
    box-shadow:
    0 10px 30px rgba(0,0,0,0.12);
}

</style>

<script>
function openForgotModal() {
    document.getElementById('forgotModal').style.display = 'flex';
}
function closeForgotModal() {
    document.getElementById('forgotModal').style.display = 'none';
}
document.getElementById('forgotModal').addEventListener('click', function(e) {
    if (e.target === this) closeForgotModal();
});

// ✅ Auto buka modal jika ada session reset error/success
@if(session('forgot_success') || session('forgot_error'))
    document.addEventListener('DOMContentLoaded', function() {
        openForgotModal();
    });
@endif
</script>

<script src="{{ asset('js/login.js') }}"></script>

</body>
</html>