<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SI-MORA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style="min-height:100vh; display:flex; align-items:center; justify-content:center; background:#f3e9d7; font-family:'Poppins',sans-serif;">

<div style="background:#fff; border-radius:16px; padding:40px; width:420px; max-width:90vw; box-shadow:0 10px 30px rgba(0,0,0,0.1); text-align:center;">
    
    <div style="width:70px; height:70px; background:#fef2f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
        <i class="fa-solid fa-key" style="font-size:30px; color:#7f1d1d;"></i>
    </div>

    <h2 style="color:#7f1d1d; margin-bottom:8px; font-size:22px;">Reset Kata Sandi</h2>
    <p style="color:#666; font-size:13px; margin-bottom:25px;">Masukkan kata sandi baru untuk akun Anda.</p>

    @if(session('reset_success'))
        <div style="background:#d4edda; color:#155724; padding:12px; border-radius:8px; margin-bottom:20px; font-size:13px;">
            ✅ {{ session('reset_success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:#fef2f2; color:#7f1d1d; padding:12px; border-radius:8px; margin-bottom:20px; font-size:13px;">
            ⚠️ {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.process') }}" style="text-align:left;">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div style="margin-bottom:15px;">
            <label style="font-size:12px; font-weight:600; color:#555; display:block; margin-bottom:6px;">Email</label>
            <input type="email" name="email" placeholder="Email terdaftar" required
                value="{{ $email ?? old('email') }}"
                style="width:100%; padding:11px 14px; border:1px solid #ddd; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box; font-family:inherit;">
        </div>

        <div style="margin-bottom:15px;">
            <label style="font-size:12px; font-weight:600; color:#555; display:block; margin-bottom:6px;">Kata Sandi Baru</label>
            <input type="password" name="password" placeholder="Minimal 6 karakter" required
                style="width:100%; padding:11px 14px; border:1px solid #ddd; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box; font-family:inherit;">
        </div>

        <div style="margin-bottom:25px;">
            <label style="font-size:12px; font-weight:600; color:#555; display:block; margin-bottom:6px;">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" required
                style="width:100%; padding:11px 14px; border:1px solid #ddd; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box; font-family:inherit;">
        </div>

        <button type="submit"
            style="width:100%; padding:12px; background:#7f1d1d; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; font-family:inherit;">
            Reset Password
        </button>
    </form>

    <a href="/" style="display:block; margin-top:20px; color:#7f1d1d; font-size:13px; text-decoration:none;">
        ← Kembali ke Login
    </a>

</div>

</body>
</html>