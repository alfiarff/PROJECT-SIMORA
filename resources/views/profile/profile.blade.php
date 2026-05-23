@php
    $layout = match(Auth::user()->role) {
        'dokter'   => 'dashboard-dokter',
        'apoteker' => 'dashboard-apoteker',
        'admin'    => 'dashboard-pmik',
        default    => 'dashboard-pmik',
    };
@endphp
@extends($layout)

@section('hide_search', true)

@section('content')
<style>
    .profile-wrapper {
        width: 100%;
    }

        .profile-wrapper .recentOrders {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        width: 100%;

        height: auto !important;
        min-height: 100% !important;
        overflow: visible !important;
    }
    
    .profile-wrapper .cardHeader h2 {
        margin-bottom: 25px;
        color: #333;
        font-size: 22px;
    }

    .profile-wrapper .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        box-sizing: border-box; 
        outline: none;
        transition: border-color 0.3s ease;
        font-family: inherit;
    }

    .profile-wrapper .form-control:focus {
        border-color: #75162d;
        box-shadow: 0 0 0 3px rgba(117, 22, 45, 0.1);
    }
    
    .profile-wrapper .form-group {
        margin-bottom: 20px;
    }

    .details.profile-wrapper {
    width: 100%;
    min-height: auto !important;
    height: auto !important;
    overflow: visible !important;
    }

    .profile-wrapper .recentOrders {
        min-height: auto !important;
        height: auto !important;
        overflow: visible !important;
    }

    .main {
        height: auto !important;
        overflow: visible !important;
    }

    .details {
        height: auto !important;
        overflow: visible !important;
    }

    .details.profile-wrapper {
    display: block !important;
    height: auto !important;
    min-height: 100vh;
    overflow: visible !important;
}

.main {
    height: auto !important;
    overflow: visible !important;
}

body {
    overflow-y: auto !important;
}

</style>

<div class="details profile-wrapper" style="padding-bottom:40px;">
    <div class="recentOrders" style="padding-bottom:50px;">
        <div class="cardHeader">
            <h2>Pengaturan Profil Akun</h2>
        </div>

        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ Tambahan: tampilkan error validasi --}}
        @if($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                <strong>Gagal menyimpan:</strong>
                <ul style="margin-top: 5px; padding-left: 20px; margin-bottom: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ Ganti action dengan route name --}}
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label style="font-weight: 600; margin-bottom: 8px; display: block; color: #444;">Foto Profil</label>
                
                @if(Auth::user()->foto)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto Profil" style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid #75162d; padding: 2px;">
                    </div>
                @endif
                
                <input type="file" name="foto" class="form-control" accept="image/*" style="padding: 8px;">
                @if(Auth::user()->foto)
                    <small style="color: #666; display: block; margin-top: 6px; font-size: 13px;">* Biarkan kosong jika tidak ingin mengganti foto saat ini.</small>
                @endif
            </div>

            <div class="form-group">
                <label style="font-weight: 600; margin-bottom: 8px; display: block; color: #444;">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
            </div>
            
            <div class="form-group">
                <label style="font-weight: 600; margin-bottom: 8px; display: block; color: #444;">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
            </div>

            <div class="form-group">
                <label style="font-weight: 600; margin-bottom: 8px; display: block; color: #444;">
                    Password Lama
                </label>

                <input type="password"
                    name="current_password"
                    class="form-control"
                    placeholder="Masukkan password lama">
            </div>
            
            <div class="form-group">
                <label style="font-weight: 600; margin-bottom: 8px; display: block; color: #444;">Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diganti">
            </div>
            
            <button type="submit" style="margin-top: 15px; background-color: #75162d; color: white; padding: 12px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; width: 100%; font-size: 16px; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#5a1122'" onmouseout="this.style.backgroundColor='#75162d'">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection