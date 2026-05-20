@extends('dashboard-dokter')

@section('hide_search', true)

@section('content')
<style>
   @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");

    .simora-form-container {
        font-family: "Ubuntu", sans-serif;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        padding: 40px 15px;
        background-color: #f9f9f9;
    }

    .form-wrapper {
        width: 100%;
        max-width: 850px;
        background: #fff;
        padding: 50px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin: 0 auto;
    }

    .form-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .form-image {
        display: block;
        margin: 0 auto 15px;
        width: 150px; 
        height: auto;
    }

    .form-title {
        font-size: 22px;
        font-weight: 700;
        color: #75162d;
        margin-bottom: 8px;
    }

    .form-description {
        font-size: 13px;
        color: #666;
        line-height: 1.5;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .full-width {
        grid-column: span 2;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        margin-bottom: 8px;
        font-weight: 500;
        color: #444;
        font-size: 13px;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: 0.3s;
        font-family: "Ubuntu", sans-serif;
    }

    .form-textarea {
        height: 100px;
        resize: vertical;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #75162d;
        box-shadow: 0 0 0 2px rgba(117,22,45,0.1);
    }

    .dynamic-obat-container {
        grid-column: span 2;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* DIPERBARUI: Kolom Grid disesuaikan untuk input Jumlah */
    .obat-row {
        display: grid;
        grid-template-columns: 2fr 2fr 1fr auto; 
        gap: 15px;
        align-items: end;
    }

    .btn-add-obat {
        background-color: #e9ecef;
        color: #333;
        border: 1px solid #ccc;
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        align-self: flex-start;
        margin-top: 5px;
        transition: 0.3s;
    }

    .btn-add-obat:hover { background-color: #d3d9df; }

    .btn-remove-obat {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 12px 15px;
        border-radius: 6px;
        cursor: pointer;
        height: 43px; 
    }

    .consent-group {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        margin: 30px 0 20px 0;
        font-size: 13px;
        color: #555;
    }

    .submit-btn {
        width: 100%;
        padding: 14px;
        background: #75162d;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .submit-btn:hover {
        background: #540816;
    }

    .back-links {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 20px;
    }

    .back-link-item {
        text-decoration: none;
        color: #75162d;
        font-size: 13px;
    }

    .back-link-item:hover {
        text-decoration: underline;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    @media(max-width:768px){
        .form-grid { grid-template-columns: 1fr; }
        .full-width { grid-column: span 1; }
        .dynamic-obat-container { grid-column: span 1; }
        .obat-row { grid-template-columns: 1fr; gap: 10px; }
        .form-wrapper { padding: 30px 20px; }
    }
</style>

<div class="simora-form-container">
    <div class="form-wrapper">

        <div class="form-header">
            <img src="{{ asset('images/logosimora.png') }}" class="form-image" alt="Logo SI-MORA">
            <h2 class="form-title">Edit Resep Obat Pasien</h2>
            <p class="form-description">
                Sistem Informasi Monitoring dan Resep Obat (SI-MORA).<br>
                Perbarui informasi diagnosa atau resep obat pasien jika diperlukan.
            </p>
        </div>

        @if ($errors->any())
            <div class="alert-danger">
                <strong>Gagal menyimpan resep!</strong>
                <ul style="margin-top: 5px; margin-bottom: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/resep/update/{{ $resep->id }}" method="POST">
            @csrf
            
            <div class="form-grid">
                
                <div class="form-group full-width">
                    <label class="form-label">Pilih Pasien *</label>
                    <select name="pasien_id" class="form-select" required>
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($pasiens ?? [] as $p)
                            <option value="{{ $p->id }}" {{ (old('pasien_id', $resep->pasien_id) == $p->id) ? 'selected' : '' }}>
                                {{ $p->nama_lengkap ?? $p->nama_pasien }} - {{ $p->no_rm ?? $p->nomor_rm }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Diagnosa Pasien *</label>
                    <input type="text" name="diagnosa" class="form-input" value="{{ old('diagnosa', $resep->diagnosa) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Dokter *</label>
                    <input type="text" name="nama_dokter" class="form-input" value="{{ old('nama_dokter', $resep->nama_dokter) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">SIP Dokter *</label>
                    <input type="text" name="sip_dokter" class="form-input" value="{{ old('sip_dokter', $resep->sip_dokter) }}" required>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Tanggal Resep *</label>
                    <input type="date" name="tanggal_resep" class="form-input" value="{{ old('tanggal_resep', $resep->tanggal_resep) }}" required>
                </div>

                @php
                    // Memecah teks dari database menjadi array (Termasuk array Jumlah)
                    $obat_array = explode(', ', $resep->nama_obat);
                    $dosis_array = explode(', ', $resep->dosis_obat);
                    $jumlah_array = explode(', ', $resep->jumlah); // <-- TAMBAHAN
                @endphp

            <div class="dynamic-obat-container" id="obat-container">
            @foreach($obat_array as $index => $obat)
            <div class="obat-row">
            <div class="form-group">
                @if($index == 0) <label class="form-label">Nama Obat *</label> @endif
                <input type="text" name="nama_obat[]" class="form-input" value="{{ trim($obat) }}" placeholder="Nama Obat" required>
            </div>
            <div class="form-group">
                @if($index == 0) <label class="form-label">Dosis Obat *</label> @endif
                <input type="text" name="dosis_obat[]" class="form-input" value="{{ trim($dosis_array[$index] ?? '') }}" placeholder="Dosis Obat" required>
            </div>
            <div class="form-group">
                @if($index == 0) <label class="form-label">Jumlah *</label> @endif
                <input type="number" name="jumlah[]" class="form-input" value="{{ trim($jumlah_array[$index] ?? '') }}" placeholder="Jml" required min="1">
            </div>
            <div style="display:flex; align-items:flex-end;">
                @if($index > 0)
                    <button type="button" class="btn-remove-obat" onclick="hapusObat(this)">X</button>
                @else
                    <div style="height:43px; width:43px;"></div> {{-- spacer sejajar tombol X --}}
                @endif
            </div>
            </div>
            @endforeach
            </div>       
                <button type="button" class="btn-add-obat" id="btn-tambah-obat">+ Tambah Obat Lainnya</button>

                <div class="form-group full-width" style="margin-top: 10px;">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-textarea">{{ old('keterangan', $resep->keterangan) }}</textarea>
                </div>

            </div> 
            
            <div class="consent-group">
                <input type="checkbox" id="consent" required style="margin-top: 2px;">
                <label for="consent">
                    Saya mengonfirmasi bahwa seluruh informasi yang diperbarui sudah benar dan valid.
                </label>
            </div>

            <button type="submit" class="submit-btn">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const obatContainer = document.getElementById('obat-container');
        const btnTambahObat = document.getElementById('btn-tambah-obat');

        btnTambahObat.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.classList.add('obat-row');

            // DIPERBARUI: Menambahkan input Jumlah di JavaScript
            newRow.innerHTML = `
                <div class="form-group">
                    <input type="text" name="nama_obat[]" class="form-input" placeholder="Nama Obat" required>
                </div>
                <div class="form-group">
                    <input type="text" name="dosis_obat[]" class="form-input" placeholder="Dosis Obat" required>
                </div>
                <div class="form-group">
                    <input type="number" name="jumlah[]" class="form-input" placeholder="Jml" required min="1">
                </div>
                <div>
                    <button type="button" class="btn-remove-obat" onclick="hapusObat(this)">X</button>
                </div>
            `;

            obatContainer.appendChild(newRow);
        });
    });

    function hapusObat(button) {
        const row = button.closest('.obat-row');
        if(row) {
            row.remove();
        }
    }
</script>
@endsection