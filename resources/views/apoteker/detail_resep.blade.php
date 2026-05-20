@extends('dashboard-apoteker')
@section('hide_search', true)
@section('content')
<style>
   @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");

    .simora-container {
        font-family: "Ubuntu", sans-serif;
        padding: 30px;
        background-color: #f4f6f9; /* Warna background abu-abu terang */
        min-height: 100vh;
    }

    /* Header & Tombol Atas */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
    }

    .page-title {
        color: #75162d;
        font-weight: 700;
        margin-bottom: 5px;
        font-size: 24px;
    }

    .page-subtitle {
        color: #666;
        font-size: 14px;
    }

    .btn-kembali {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        display: inline-block;
        margin-top: 15px;
    }

    .btn-aksi {
        background-color: #75162d;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-aksi:hover { background-color: #5a1122; color: white;}
    
    .btn-selesai { background-color: #198754; }
    .btn-selesai:hover { background-color: #157347; }

    /* Layout 2 Kolom */
    .layout-grid {
        display: grid;
        grid-template-columns: 1fr 1.8fr; /* Kolom kanan lebih lebar */
        gap: 30px;
        align-items: start;
    }

    /* --- STYLING KOLOM KIRI (Info Card) --- */
    .info-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        margin-bottom: 20px;
    }

    .info-card h3 {
        color: #75162d;
        font-size: 16px;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .info-row {
        display: flex;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .info-label { width: 100px; color: #555; font-weight: 500;}
    .info-colon { width: 20px; color: #555; }
    .info-value { flex: 1; color: #222; font-weight: 500;}

    .note-box {
        background-color: #e9ecef;
        padding: 15px;
        border-radius: 8px;
        font-size: 13px;
        color: #444;
        line-height: 1.6;
        margin-top: 10px;
    }

    .petunjuk-text {
        font-size: 13px;
        color: #666;
        line-height: 1.5;
        text-align: center;
    }

    /* --- STYLING KOLOM KANAN (Preview Kertas Resep) --- */
    .paper-preview {
        background: #fff;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid #eaeaea;
        position: relative;
    }

    .kop-surat {
        text-align: center;
        border-bottom: 2px solid #333;
        padding-bottom: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .kop-surat img { width: 50px; }
    .kop-teks h2 { margin: 0; font-size: 20px; color: #222; letter-spacing: 1px;}
    .kop-teks p { margin: 5px 0 0; font-size: 12px; color: #555; }

    .judul-resep {
        text-align: center;
        font-size: 16px;
        font-weight: 700;
        color: #75162d;
        margin-bottom: 20px;
        letter-spacing: 1px;
    }

    .meta-resep-kertas {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-bottom: 20px;
    }

    .garis-batas {
        border-top: 1px solid #ccc;
        margin: 15px 0;
    }

    .list-obat-kertas {
        font-size: 13px;
        line-height: 1.8;
        min-height: 200px; /* Jarak agar kertas terlihat panjang */
    }

    .list-obat-kertas ol { padding-left: 20px; margin: 0; }
    .list-obat-kertas li { margin-bottom: 15px; }
    .obat-nama { font-weight: 700; font-size: 14px; }
    .obat-dosis { color: #666; font-size: 12px; display: block; margin-left: 5px;}

    .footer-kertas {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-top: 40px;
    }

    .footer-catatan { width: 60%; color: #444; }
    .footer-ttd { width: 30%; text-align: center; }
    .qr-placeholder { width: 60px; height: 60px; background: #eee; margin: 10px auto; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;}

    /* Membuat Nomor Resep Dummy agar mirip desain */
    @php
        $no_resep = 'RSP-' . \Carbon\Carbon::parse($resep->created_at)->format('Y') . '-' . str_pad($resep->id, 4, '0', STR_PAD_LEFT);
    @endphp

</style>

<div class="simora-container">
    
    <div class="header-section">
        <div>
            <h2 class="page-title">Cetak Resep</h2>
            <p class="page-subtitle">Tinjau resep sebelum diselesaikan / dicetak.</p>
            <a href="/apoteker/resep" class="btn-kembali">&larr; Kembali ke Resep Masuk</a>
        </div>

        <div>
            @if($resep->status == 'Pending')
                <form action="{{ route('resep.updateStatus', $resep->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin obat sudah disiapkan? Stok akan terpotong.');">
                    @csrf
                    <input type="hidden" name="status" value="Selesai">
                    <button type="submit" class="btn-aksi btn-selesai">
                        <i class="bi bi-check2-circle"></i> Selesaikan Resep
                    </button>
                </form>
            @else
                <a href="{{ route('apoteker.resep.cetak', $resep->id) }}" target="_blank" class="btn-aksi">
                    <i class="bi bi-printer"></i> Cetak Resep
                </a>
            @endif
        </div>
    </div>

    <div class="layout-grid">
        
        <div class="kolom-kiri">
            
            <div class="info-card">
                <h3>Informasi Resep</h3>
                <div class="info-row">
                    <div class="info-label">No Resep</div>
                    <div class="info-colon">:</div>
                    <div class="info-value">{{ $no_resep }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Dokter</div>
                    <div class="info-colon">:</div>
                    <div class="info-value">{{ $resep->nama_dokter }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Pasien</div>
                    <div class="info-colon">:</div>
                    <div class="info-value">{{ $resep->pasien->nama_pasien ?? 'Unknown' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Diagnosa</div>
                    <div class="info-colon">:</div>
                    <div class="info-value">{{ $resep->diagnosa }}</div>
                </div>

                <h3 style="margin-top: 25px; margin-bottom: 10px;">Catatan Tambahan</h3>
                <div class="note-box">
                    {{ $resep->keterangan ?? 'Tidak ada catatan tambahan dari dokter.' }}
                </div>
            </div>

            <div class="info-card" style="text-align: center;">
                <h3 style="color: #444; margin-bottom: 10px;">Petunjuk</h3>
                <p class="petunjuk-text">
                    Pastikan data resep sudah sesuai sebelum diselesaikan.<br>
                    Resep hanya berlaku sesuai tanggal yang tertera.
                </p>
            </div>

        </div>

        <div class="kolom-kanan">
            
            <div class="paper-preview">
                
                <div class="kop-surat">
                    <img src="{{ asset('images/logosimora.png') }}" alt="Logo">
                    <div class="kop-teks">
                        <h2>KLINIK SI-MORA</h2>
                        <p>Jl. Raya Jember No. 123, Jember, Jawa Timur</p>
                    </div>
                </div>

                <div class="judul-resep">SALINAN RESEP</div>

                <div class="meta-resep-kertas">
                    <div style="width: 50%;">
                        <table style="width: 100%;">
                            <tr><td width="70">Dokter</td><td width="10">:</td><td>{{ $resep->nama_dokter }}</td></tr>
                            <tr><td>Pasien</td><td>:</td><td>{{ $resep->pasien->nama_pasien ?? '-' }}</td></tr>
                            <tr><td>Diagnosa</td><td>:</td><td>{{ $resep->diagnosa }}</td></tr>
                        </table>
                    </div>
                    <div style="width: 40%;">
                        <table style="width: 100%;">
                            <tr><td width="70">No Resep</td><td width="10">:</td><td>{{ $no_resep }}</td></tr>
                            <tr><td>Tanggal</td><td>:</td><td>{{ \Carbon\Carbon::parse($resep->tanggal_resep)->format('d M Y') }}</td></tr>
                        </table>
                    </div>
                </div>

                <div class="garis-batas"></div>

                <div class="list-obat-kertas">
                    @php
                        $obat_array = explode(',', $resep->nama_obat);
                        $dosis_array = explode(',', $resep->dosis_obat);
                        $jumlah_array = explode(',', $resep->jumlah);
                    @endphp
                    <ol>
                        @foreach($obat_array as $index => $nama_obat)
                            <li>
                                <span class="obat-nama">{{ trim($nama_obat) }}</span> 
                                <span style="font-weight: normal; color: #555;"> - {{ trim($jumlah_array[$index] ?? '0') }} Pcs</span>
                                <span class="obat-dosis">{{ trim($dosis_array[$index] ?? '-') }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="garis-batas"></div>

                <div class="footer-kertas">
                    <div class="footer-catatan">
                        <strong>Catatan Dokter:</strong><br>
                        {{ $resep->keterangan ?? '-' }}
                    </div>
                    <div class="footer-ttd">
                        <div>Jember, {{ \Carbon\Carbon::parse($resep->tanggal_resep)->format('d M Y') }}</div>
                        <div class="qr-placeholder">[ QR Code ]</div>
                        <div><strong>{{ $resep->nama_dokter }}</strong></div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection