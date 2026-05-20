@extends('dashboard-dokter')
@section('hide_search', false)
@section('content')
<style>
    .detail-container {
        padding: 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin: 20px;
        max-width: 800px;
    }

    .detail-header {
        border-bottom: 2px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-header h2 {
        color: #75162d;
        margin: 0;
    }

    .info-group {
        margin-bottom: 15px;
        font-size: 16px;
    }

    .info-group label {
        font-weight: 600;
        color: #555;
        display: inline-block;
        width: 150px;
    }

    .info-group span {
        color: #222;
    }

    .btn-kembali {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        transition: 0.3s;
    }

    .btn-kembali:hover {
        background-color: #5a6268;
    }
</style>

<div class="detail-container">
    <div class="detail-header">
        <h2>Detail Data Pasien</h2>
        <a href="/resep/create?pasien_id={{ $pasien->id }}" class="btn-kembali" style="background-color: #28a745; margin-top: 0;">
            + Tambah Resep
        </a>
    </div>

    <div class="info-group">
        <label>Nomor RM</label>
        <span>: {{ $pasien->nomor_rm }}</span>
    </div>
    <div class="info-group">
        <label>Nama Pasien</label>
        <span>: {{ $pasien->nama_pasien }}</span>
    </div>
    <div class="info-group">
        <label>Jenis Kelamin</label>
        <span>: {{ $pasien->jenis_kelamin }}</span>
    </div>
    <div class="info-group">
        <label>Usia</label>
        <span>: {{ $pasien->usia }} Tahun</span>
    </div>
    <div class="info-group">
        <label>Alergi Obat</label>
        <span style="color: #e74c3c; font-weight: bold;">: {{ $pasien->alergi_obat ?? 'Tidak Ada' }}</span>
    </div>

    <a href="/dokter/pasien" class="btn-kembali">Kembali ke Daftar Pasien</a>
</div>
@endsection