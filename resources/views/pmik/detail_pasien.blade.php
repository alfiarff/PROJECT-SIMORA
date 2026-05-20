@extends('dashboard-pmik') 
@section('hide_search', true)
@section('content')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap");

    .simora-container {
        font-family: "Ubuntu", sans-serif;
        padding: 30px;
        background-color: #f4f6f9;
        min-height: 100vh;
    }

    .card-detail {
        background: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        max-width: 800px; /* Membatasi lebar agar persis seperti gambar 2 */
        margin: 0;
    }

    .header-detail {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
        margin-bottom: 25px;
    }

    .header-detail h2 {
        color: #75162d;
        font-size: 22px;
        font-weight: 700;
        margin: 0;
    }

    /* Tombol Edit Hijau */
    .btn-edit {
        background-color: #5cb85c; 
        color: white;
        padding: 8px 18px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-edit:hover {
        background-color: #4cae4c;
        color: white;
    }

    .info-row {
        display: flex;
        margin-bottom: 16px;
        font-size: 15px;
    }

    .info-label {
        width: 160px;
        color: #444;
        font-weight: 600;
    }

    .info-colon {
        width: 20px;
        color: #444;
        font-weight: 600;
    }

    .info-value {
        flex: 1;
        color: #222;
    }

    .alergi-text {
        color: #d9534f;
        font-weight: 700;
    }

    /* Tombol Kembali Abu-abu */
    .btn-kembali {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
        margin-top: 25px;
        transition: 0.3s;
        border: none;
    }

    .btn-kembali:hover {
        background-color: #5a6268;
        color: white;
    }
</style>

<div class="simora-container">
    <div class="card-detail">
        
        <div class="header-detail">
            <h2>Detail Data Pasien</h2>
           <a href="{{ route('pasien.index') }}" class="btn-kembali">Kembali ke Daftar Pasien</a>
        </div>

        <div class="info-row">
            <div class="info-label">Nomor RM</div>
            <div class="info-colon">:</div>
            <div class="info-value">{{ $pasien->nomor_rm }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Nama Pasien</div>
            <div class="info-colon">:</div>
            <div class="info-value">{{ $pasien->nama_pasien }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Jenis Kelamin</div>
            <div class="info-colon">:</div>
            <div class="info-value">{{ $pasien->jenis_kelamin }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Tempat, Tgl Lahir</div>
            <div class="info-colon">:</div>
            <div class="info-value">
                {{ $pasien->tempat_lahir ?? '-' }}, 
                {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d F Y') }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label">Usia</div>
            <div class="info-colon">:</div>
            <div class="info-value">{{ $pasien->usia }} Tahun</div>
        </div>

        <div class="info-row">
            <div class="info-label">Alamat</div>
            <div class="info-colon">:</div>
            <div class="info-value">{{ $pasien->alamat }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Alergi Obat</div>
            <div class="info-colon">:</div>
            <div class="info-value">
                @if($pasien->alergi_obat && strtolower($pasien->alergi_obat) != 'tidak ada' && strtolower($pasien->alergi_obat) != '-')
                    <span class="alergi-text">{{ $pasien->alergi_obat }}</span>
                @else
                    -
                @endif
            </div>
        </div>

        <div class="info-row">
        <div class="info-label">Status Asuransi</div>
        <div class="info-colon">:</div>
        <div class="info-value">
        @if($pasien->status_asuransi == 'BPJS')
            <span style="
                background: #e8f5e9; color: #1b5e20;
                border: 1px solid #2e7d32;
                padding: 4px 14px; border-radius: 20px;
                font-size: 13px; font-weight: 600;
            ">🏥 BPJS</span>
            @elseif($pasien->status_asuransi == 'Umum')
            <span style="
                background: #e3f2fd; color: #0d47a1;
                border: 1px solid #1565c0;
                padding: 4px 14px; border-radius: 20px;
                font-size: 13px; font-weight: 600;
            ">👤 Umum</span>
         @else
            -
            @endif
        </div>
    </div>
        
    </div>
</div>
@endsection
