@extends('layouts.app')

@section('title', 'Dashboard Admin SI-MORA')
@section('hide_search', true)

@section('content')
<style>
    .page-header { margin-bottom: 25px; }
    .page-header h1 { font-size: 24px; font-weight: 700; color: #222; }
    .page-header p { color: #999; font-size: 14px; margin-top: 3px; }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
    .stat-card { background: #fff; border-radius: 16px; padding: 25px; display: flex; align-items: center; gap: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: 0.3s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .stat-icon { width: 55px; height: 55px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0; }
    .stat-icon.purple { background: #f0ebff; color: #7c3aed; }
    .stat-icon.green  { background: #e8f8f0; color: #16a34a; }
    .stat-icon.blue   { background: #e8f4fd; color: #2563eb; }
    .stat-icon.red    { background: #fef2f2; color: #dc2626; }
    .stat-info .stat-number { font-size: 28px; font-weight: 700; color: #222; line-height: 1; }
    .stat-info .stat-label  { font-size: 13px; color: #999; margin-top: 4px; }

    .role-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; }
    .role-card { background: #fff; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 4px solid; transition: 0.3s; }
    .role-card:hover { transform: translateY(-2px); }
    .role-card.admin    { border-color: #7c3aed; }
    .role-card.dokter   { border-color: #2563eb; }
    .role-card.apoteker { border-color: #16a34a; }
    .role-card.pmik     { border-color: #ea580c; }
    .role-card .role-count { font-size: 32px; font-weight: 700; color: #222; }
    .role-card .role-name  { font-size: 13px; color: #999; margin-top: 4px; }

    .table-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 25px; }
    .table-card-header { padding: 20px 25px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f0f0f0; }
    .table-card-header h3 { font-size: 16px; font-weight: 600; color: #222; }
    .search-input { padding: 8px 16px; border: 1px solid #eee; border-radius: 8px; font-size: 13px; outline: none; width: 220px; transition: border-color 0.2s; font-family: inherit; }
    .search-input:focus { border-color: #560b18; }

    .table-admin { width: 100%; border-collapse: collapse; }
    .table-admin th { background: #fafafa; padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 600; color: #999; text-transform: uppercase; border-bottom: 1px solid #f0f0f0; }
    .table-admin td { padding: 15px 20px; border-bottom: 1px solid #f9f9f9; font-size: 13px; color: #222; vertical-align: middle; }
    .table-admin tr:last-child td { border-bottom: none; }
    .table-admin tr { transition: all 0.2s ease; }
    .table-admin tbody tr:hover td { background-color: #5a1122 !important; color: #fff !important; }

    .user-avatar-sm { width: 36px; height: 36px; border-radius: 50%; background: #560b18; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; overflow: hidden; margin-right: 10px; flex-shrink: 0; }
    .user-avatar-sm img { width: 100%; height: 100%; object-fit: cover; }

    .badge-role { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: capitalize; }
    .badge-admin    { background:#f0ebff; color:#7c3aed; }
    .badge-dokter   { background:#e8f4fd; color:#2563eb; }
    .badge-apoteker { background:#e8f8f0; color:#16a34a; }
    .badge-pmik     { background:#fff7ed; color:#ea580c; }
    .badge-online  { background:#e8f8f0; color:#16a34a; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap; display:inline-block; }
    .badge-offline { background:#f5f5f5; color:#999; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap; display:inline-block; }

    .btn-sm { padding: 5px 10px; border-radius: 6px; font-size: 11px; font-weight: 500; border: none; cursor: pointer; text-decoration: none; display: inline-block; margin: 2px; transition: 0.2s; white-space: nowrap; font-family: inherit; }
    .btn-role   { background:#e8f4fd; color:#2563eb; }
    .btn-role:hover { background:#2563eb; color:#fff; }
    .btn-reset  { background:#fff7ed; color:#ea580c; }
    .btn-reset:hover { background:#ea580c; color:#fff; }
    .btn-delete { background:#fef2f2; color:#dc2626; }
    .btn-delete:hover { background:#dc2626; color:#fff; }

    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .modal-box { background: #fff; border-radius: 16px; padding: 30px; width: 420px; max-width: 90vw; animation: fadeInUp 0.3s ease; position: relative; }
    .modal-box h3 { font-size: 18px; font-weight: 700; color: #222; margin-bottom: 20px; }
    .modal-close { position: absolute; top: 15px; right: 20px; background: none; border: none; font-size: 22px; cursor: pointer; color: #999; }
    .modal-close:hover { color: #333; }
    .form-group { margin-bottom: 15px; text-align: left; }
    .form-group label { display: block; font-size: 13px; font-weight: 500; color: #555; margin-bottom: 6px; }
    .form-control-admin { width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 8px; font-size: 13px; outline: none; transition: 0.2s; font-family: inherit; box-sizing: border-box; }
    .form-control-admin:focus { border-color: #560b18; }
    .btn-primary-admin { width: 100%; padding: 12px; background: #560b18; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 5px; transition: 0.2s; font-family: inherit; }
    .btn-primary-admin:hover { background: #3d0812; }

    .alert-success { background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; }
    .alert-error   { background: #fef2f2; color: #7f1d1d; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; }

    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .role-grid  { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .role-grid  { grid-template-columns: repeat(2, 1fr); }
    }
</style>

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
            <div class="stat-number">{{ $totalUsers ?? 0 }}</div>
            <div class="stat-label">Total Akun</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><ion-icon name="wifi-outline"></ion-icon></div>
        <div class="stat-info">
            <div class="stat-number">{{ $onlineUsers ?? 0 }}</div>
            <div class="stat-label">Sedang Online</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><ion-icon name="person-outline"></ion-icon></div>
        <div class="stat-info">
            <div class="stat-number">{{ $totalPasien ?? 0 }}</div>
            <div class="stat-label">Total Pasien</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><ion-icon name="receipt-outline"></ion-icon></div>
        <div class="stat-info">
            <div class="stat-number">{{ $totalResep ?? 0 }}</div>
            <div class="stat-label">Total Resep</div>
        </div>
    </div>
</div>

{{-- ROLE BREAKDOWN --}}
<div class="role-grid">
    <div class="role-card admin">
        <div class="role-count">{{ $roleCount['admin'] ?? 0 }}</div>
        <div class="role-name"> Admin</div>
    </div>
    <div class="role-card dokter">
        <div class="role-count">{{ $roleCount['dokter'] ?? 0 }}</div>
        <div class="role-name"> Dokter</div>
    </div>
    <div class="role-card apoteker">
        <div class="role-count">{{ $roleCount['apoteker'] ?? 0 }}</div>
        <div class="role-name"> Apoteker</div>
    </div>
    <div class="role-card pmik">
        <div class="role-count">{{ $roleCount['pmik'] ?? 0 }}</div>
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
                <td>{{ $user->email }}</td>
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
                <td style="font-size:12px; white-space:nowrap;">
                    {{ $user->last_seen ? $user->last_seen->diffForHumans() : 'Belum pernah login' }}
                </td>
                <td>
                    <button onclick="openRoleModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->role }}')" class="btn-sm btn-role">
                        <i class="bi bi-shield"></i> Role
                    </button>
                    <button onclick="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}')" class="btn-sm btn-reset">
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
                <td colspan="7" style="text-align:center; padding:30px; color:#888;">Belum ada akun terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODAL UBAH ROLE --}}
<div class="modal-overlay" id="roleModal">
    <div class="modal-box">
        <button class="modal-close" onclick="closeAdminModal('roleModal')">&times;</button>
        <h3>Ubah Role Pengguna</h3>
        <p style="font-size:13px; color:#666; margin-bottom:20px;">Mengubah role: <strong id="roleUserName"></strong></p>
        <form method="POST" id="roleForm">
            @csrf
            <div class="form-group">
                <label>Pilih Role Baru</label>
                <select name="role" class="form-control-admin" id="roleSelect">
                    <option value="admin"> Admin</option>
                    <option value="dokter"> Dokter</option>
                    <option value="apoteker"> Apoteker</option>
                    <option value="pmik"> PMIK</option>
                </select>
            </div>
            <button type="submit" class="btn-primary-admin">Simpan Perubahan</button>
        </form>
    </div>
</div>

{{-- MODAL RESET PASSWORD --}}
<div class="modal-overlay" id="resetModal">
    <div class="modal-box">
        <button class="modal-close" onclick="closeAdminModal('resetModal')">&times;</button>
        <h3>Reset Password</h3>
        <p style="font-size:13px; color:#666; margin-bottom:20px;">Reset password untuk: <strong id="resetUserName"></strong></p>
        <form method="POST" id="resetForm">
            @csrf
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="new_password" class="form-control-admin" placeholder="Minimal 6 karakter" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="new_password_confirmation" class="form-control-admin" placeholder="Ulangi password baru" required>
            </div>
            <button type="submit" class="btn-primary-admin">Reset Password</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('searchUser').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('#userTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    function openRoleModal(id, name, currentRole) {
        document.getElementById('roleUserName').textContent = name;
        document.getElementById('roleForm').action = `/admin/user/${id}/role`;
        document.getElementById('roleSelect').value = currentRole;
        document.getElementById('roleModal').style.display = 'flex';
    }

    function openResetModal(id, name) {
        document.getElementById('resetUserName').textContent = name;
        document.getElementById('resetForm').action = `/admin/user/${id}/reset-password`;
        document.getElementById('resetModal').style.display = 'flex';
    }

    function closeAdminModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });
    });
</script>
@endpush