@extends('dashboard-dokter')

{{-- Tambahkan baris ini untuk menyembunyikan search bar di topbar --}}
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
        background-color: #f9f9f9; /* Opsional: memberi kontras dengan form putih */
    }

    .form-wrapper {
        width: 100%;
        max-width: 850px; /* Diperkecil sedikit agar proporsinya persis seperti gambar */
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
        /* UBAH UKURAN INI DARI 60px MENJADI 150px ATAU SESUAI SELERA */
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

    /* GRID SYSTEM UNTUK FORM */
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

    /* Styling Tambah Obat */
    .dynamic-obat-container {
        grid-column: span 2;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

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
        height: 43px; /* Menyesuaikan tinggi input */
    }

    /* Footer / Submit */
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
            <h2 class="form-title">Formulir Resep Obat Pasien</h2>
            <p class="form-description">
                Sistem Informasi Monitoring dan Resep Obat (SI-MORA).<br>
                Data pasien bersifat rahasia dan dilindungi. Mohon isi seluruh data dengan benar.
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

        <form action="/resep/store" method="POST">
            @csrf

            <div class="form-grid">
                
               <div class="form-group full-width">
                <label class="form-label">Pilih Pasien *</label>
                <select name="pasien_id" id="pasien_select" class="form-select" required onchange="autoFillAsuransi()">
                <option value="">-- Pilih Pasien --</option>
                @foreach($pasiens ?? [] as $p)
                @php $selected_id = old('pasien_id') ?? ($pasien_id_terpilih ?? ''); @endphp
                <option value="{{ $p->id }}" {{ $selected_id == $p->id ? 'selected' : '' }}>
                {{ $p->nama_pasien }} - {{ $p->nomor_rm }}
                </option>
            @endforeach
            </select>
            </div>

<div class="form-group full-width">
    <label class="form-label">Status Asuransi Pasien</label>
    <div style="position: relative;">
        <input type="text" id="status_asuransi_display"
            class="form-input"
            value="Pilih pasien terlebih dahulu"
            readonly
            style="background-color:#f9f9f9; cursor:not-allowed; font-weight:600; color:#999; padding-left:42px;">
        <span id="asuransi_icon" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:18px; line-height:1;">—</span>
    </div>
    <input type="hidden" name="status_asuransi" id="status_asuransi_input" value="">
</div>

                <div class="form-group full-width">
                    <label class="form-label">Diagnosa Pasien *</label>
                    <input type="text" name="diagnosa" class="form-input" value="{{ old('diagnosa') }}" placeholder="Contoh: Hipertensi, Influenza..." required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Dokter *</label>
                    <input type="text" name="nama_dokter" class="form-input" value="{{ auth()->user()->name }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">SIP Dokter *</label>
                    <input type="text" name="sip_dokter" class="form-input" value="{{ old('sip_dokter') }}" required>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Tanggal Resep *</label>
                    <input type="date" name="tanggal_resep" class="form-input" value="{{ old('tanggal_resep') }}" required>
                </div>

                <div class="dynamic-obat-container" id="obat-container">
                    <div class="obat-row">
            <div class="form-group">
                <label class="form-label">Nama Obat *</label>
                <input type="text" name="nama_obat[]" class="form-input" value="{{ old('nama_obat.0') }}" required placeholder="Contoh: Paracetamol">
            </div>
            <div class="form-group">
                <label class="form-label">Dosis Obat *</label>
                <input type="text" name="dosis_obat[]" class="form-input" value="{{ old('dosis_obat.0') }}" required placeholder="3 x 1">
            </div>
            <div class="form-group">
                <label class="form-label">Jumlah *</label>
                <input type="number" name="jumlah[]" class="form-input" value="{{ old('jumlah.0') }}" required min="1" placeholder="Jumlah">
            </div>
            <div style="display:flex; align-items:flex-end;">
        <div style="height:43px; width:43px;"></div> {{-- spacer agar sejajar dengan tombol X --}}
            </div>
        </div>
                </div>
                
                <button type="button" class="btn-add-obat" id="btn-tambah-obat">+ Tambah Obat Lainnya</button>

                <div class="form-group full-width" style="margin-top: 10px;">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-textarea" placeholder="Opsional">{{ old('keterangan') }}</textarea>
                </div>

            </div> 
            
            <div class="consent-group">
                <input type="checkbox" id="consent" required style="margin-top: 2px;">
                <label for="consent">
                    Saya mengonfirmasi bahwa seluruh informasi yang diberikan sudah benar dan resep valid.
                </label>
            </div>

            <button type="submit" class="submit-btn">Kirim Resep</button>
        </form>
    </div>
</div>

<script>
    // ===== DATA ASURANSI PASIEN =====
const pasienAsuransi = @json($pasienAsuransi ?? []);

function autoFillAsuransi() {
    const pasienId    = document.getElementById('pasien_select').value;
    const display     = document.getElementById('status_asuransi_display');
    const icon        = document.getElementById('asuransi_icon');
    const hiddenInput = document.getElementById('status_asuransi_input');

    if (!pasienId || !pasienAsuransi[pasienId]) {
        display.value             = 'Pilih pasien terlebih dahulu';
        display.style.color       = '#999';
        display.style.background  = '#f9f9f9';
        display.style.borderColor = '#ddd';
        icon.textContent          = '—';
        hiddenInput.value         = '';
        return;
    }

    const status      = pasienAsuransi[pasienId];
    hiddenInput.value = status;

    if (status === 'BPJS') {
        display.value             = 'BPJS';
        display.style.color       = '#1b5e20';
        display.style.background  = '#e8f5e9';
        display.style.borderColor = '#2e7d32';
        icon.textContent          = '🏥';
    } else {
        display.value             = 'Umum / Reguler';
        display.style.color       = '#0d47a1';
        display.style.background  = '#e3f2fd';
        display.style.borderColor = '#1565c0';
        icon.textContent          = '👤';
    }
}

    // Jalankan saat halaman load jika sudah ada pasien terpilih (old value)
    document.addEventListener('DOMContentLoaded', autoFillAsuransi);

    document.addEventListener('DOMContentLoaded', function() {
        const obatContainer = document.getElementById('obat-container');
        const btnTambahObat = document.getElementById('btn-tambah-obat');

        btnTambahObat.addEventListener('click', function() {
            // Buat elemen div baru untuk baris obat
            const newRow = document.createElement('div');
            newRow.classList.add('obat-row');

            // Isi HTML di dalamnya
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

            // Tambahkan ke container
            obatContainer.appendChild(newRow);
        });
    });

    // Fungsi untuk menghapus baris obat
    function hapusObat(button) {
        // Cari elemen parent (.obat-row) dan hapus
        const row = button.closest('.obat-row');
        if(row) {
            row.remove();
        }
    }
</script>
@endsection