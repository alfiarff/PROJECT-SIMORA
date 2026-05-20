@extends('dashboard-pmik')

@section('hide_search', true)

@section('content')
<style>
    .edit-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 20px 15px;
    }

    .form-wrapper {
        width: 100%;
        max-width: 1100px; /* Diperlebar untuk 2 kolom */
        background: #fff;
        padding: 40px;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        margin: 0 auto;
        font-family: "Ubuntu", sans-serif;
    }

    .form-header { text-align: center; margin-bottom: 30px; }
    .form-image { display: block; margin: 0 auto 20px; width: 150px; height: auto; }
    .form-title { font-size: 28px; color: #75162d; margin-bottom: 10px; }
    .form-description { font-size: 14px; color: #666; line-height: 1.6; }

    /* Pengaturan Layout Utama (2 Kolom) */
    .form-main-container {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    /* Grid untuk Desktop */
    @media (min-width: 992px) {
        .form-main-container {
            flex-direction: row;
            align-items: flex-start;
        }
        .form-column {
            flex: 1;
        }
        .column-left {
            padding-right: 30px;
            border-right: 1px solid #eee;
        }
        .column-right {
            padding-left: 30px;
        }
    }

    .section-subtitle {
        font-size: 16px;
        font-weight: 700;
        color: #75162d;
        margin-bottom: 20px;
        padding-bottom: 8px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 500; color: #444; font-size: 14px; }
    .form-input, .form-select, .form-textarea {
        width: 100%; padding: 12px; border: 1px solid #ddd;
        border-radius: 8px; font-size: 14px; transition: 0.3s;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none; border-color: #75162d; box-shadow: 0 0 0 3px rgba(117,22,45,0.15);
    }

    .footer-section {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        width: 100%;
    }
    
    .consent-group {
        display: flex; gap: 10px; align-items: flex-start; margin-bottom: 20px; font-size: 14px; color: #555;
    }

    .submit-btn {
        width: 100%; padding: 16px; background: #75162d; color: #fff;
        border: none; border-radius: 8px; font-size: 16px; font-weight: 600;
        cursor: pointer; transition: 0.3s;
    }
    .submit-btn:hover { background: #540816; transform: translateY(-2px); }
    
    .back-links {
        text-align: center; margin-top: 20px;
    }
    .back-btn {
        display: inline-block; margin: 5px 10px; text-decoration: none; color: #75162d; font-size: 14px;
    }
    .back-btn:hover { text-decoration: underline; }
</style>

<div class="edit-container">
    <div class="form-wrapper">

        <img src="{{ asset('images/logosimora.png') }}" class="form-image" alt="Logo SI-MORA">

        <div class="form-header">
            <h2 class="form-title">Formulir Edit Pasien</h2>
            <p class="form-description">
                Silakan ubah data pasien sesuai kebutuhan.
            </p>
        </div>

        {{-- Notifikasi Error Validasi jika ada --}}
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/pasien/update/{{ $pasien->id }}" method="POST">
            @csrf

            <div class="form-main-container">
                
                <div class="form-column column-left">
                    <div class="section-subtitle">
                        <span></span> Data Identitas Pasien
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" name="nama_pasien" class="form-input" value="{{ $pasien->nama_pasien }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Rekam Medis *</label>
                        <input type="text" name="nomor_rm" class="form-input" value="{{ $pasien->nomor_rm }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="Laki-laki" {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $pasien->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Tempat Lahir *</label>
                            <input type="text" name="tempat_lahir" class="form-input" value="{{ $pasien->tempat_lahir }}" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Tanggal Lahir *</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-input" value="{{ $pasien->tanggal_lahir }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Usia *</label>
                        <input type="number" name="usia" id="usia" class="form-input" value="{{ $pasien->usia }}" readonly style="background-color: #f9f9f9; cursor: not-allowed;" required>
                    </div>
                </div>

                <div class="form-column column-right">
                    <div class="section-subtitle">
                        <span></span> Informasi Medis & Kontak
                    </div>

                     <div class="form-group">
                        <label class="form-label">Asuransi *</label>
                        <select name="status_asuransi" class="form-select" required>
                        <option value="">-- Pilih Asuransi --</option>
                        <option value="BPJS"  {{ old('status_asuransi', $pasien->status_asuransi) == 'BPJS'  ? 'selected' : '' }}>BPJS Kesehatan</option>
                        <option value="Umum"  {{ old('status_asuransi', $pasien->status_asuransi) == 'Umum'  ? 'selected' : '' }}>Umum / Reguler</option>
                    </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alergi Obat *</label>
                        <input type="text" name="alergi_obat" class="form-input" value="{{ $pasien->alergi_obat }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat *</label>
                        <textarea name="alamat" rows="4" class="form-textarea" required>{{ $pasien->alamat }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keterangan Tambahan</label>
                        <textarea name="keterangan" rows="4" class="form-textarea">{{ $pasien->keterangan }}</textarea>
                    </div>
                </div>

            </div>

            <div class="footer-section">
                <div class="consent-group">
                    <input type="checkbox" required id="consent" style="margin-top: 3px;">
                    <label for="consent">Saya mengonfirmasi perubahan data sudah benar.</label>
                </div>

                <button type="submit" class="submit-btn">Update Pasien</button>
            </div>

        </form>

    </div>
</div>

<script>
    // Perhitungan usia otomatis saat tanggal lahir diubah
    document.getElementById('tanggal_lahir').addEventListener('change', function() {
        const dob = new Date(this.value);
        const today = new Date(); 
        
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();
        
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        document.getElementById('usia').value = age >= 0 ? age : 0;
    });
</script>
@endsection