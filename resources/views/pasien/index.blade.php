@extends('dashboard-pmik')

@section('hide_search', true) {{-- Sembunyikan pencarian bawaan topbar, karena Anda punya pencarian sendiri --}}

@section('content')
<style>
    /* CSS Bawaan Anda */
    :root{
        --primary:#560b18;
        --blue:#3498db;
        --orange:#f39c12;
        --red:#e74c3c;
    }

    /* 1. MEMAKSA FONT MENGIKUTI DASHBOARD (SANS-SERIF) */
    .container-pasien, 
    .container-pasien h2, 
    .table-pasien, 
    .table-pasien th, 
    .table-pasien td, 
    .btn-custom, 
    .search-box,
    .modal-content {
        font-family: inherit !important;
    }

    .container-pasien{
        width: 100%;
        margin: 0 auto;
    }

    .card-pasien{
        background: #fff;
        padding: 25px;
        border-radius: 18px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .header-pasien{
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .header-pasien h2{
        color: var(--primary);
    }

    .actions{
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-box{
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #ddd;
        min-width: 220px;
    }

    .btn-custom{
        text-decoration: none;
        border: none;
        padding: 10px 14px;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: 0.3s;
    }

    /* 2. MENGUBAH WARNA TOMBOL TAMBAH PASIEN */
    .btn-add{ background: #75162d; }
    .btn-add:hover{ background: #5a1122; }
    
    .btn-detail{ background: var(--blue); }
    .btn-edit{ background: var(--orange); }
    .btn-delete{ background: var(--red); }

    .table-wrapper{
        overflow-x: auto;
    }

    .table-pasien{
        width: 100%;
        border-collapse: collapse;
    }

    .table-pasien thead{
        background: #f3f3f3;
    }

    .table-pasien thead td{
        padding: 14px;
        font-weight: 700;
        text-align: center;
        color: #333;
    }

    .table-pasien tbody td{
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    .table-pasien tbody tr:hover{
        background: var(--primary);
        color: white;
        transition: .3s;
    }

    .table-pasien tbody tr:hover a,
    .table-pasien tbody tr:hover button{
        opacity: 0.95;
    }

    /* CSS Untuk Modal */
    .modal{
        display: none;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.55);
        z-index: 9999;
    }

    .modal-content{
        background: white;
        width: 95%;
        max-width: 500px;
        margin: 10% auto;
        border-radius: 15px;
        padding: 25px;
        position: relative;
    }

    .close{
        position: absolute;
        top: 12px;
        right: 16px;
        font-size: 26px;
        cursor: pointer;
        color: #333;
    }

    .modal-content h3{
        color: #75162d; /* Mengikuti warna tema */
        margin-bottom: 15px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .modal-content p{
        line-height: 1.8;
        color: #444;
    }

    @media(max-width:768px){
        .header-pasien{ flex-direction: column; align-items: flex-start; }
        .actions{ width: 100%; flex-direction: column; }
        .search-box{ width: 100%; }
    }
    
    .btn-back-dashboard {
        display: inline-flex;
        align-items: center;
        padding: 10px 18px;
        background-color: transparent;
        color: #75162d;
        border: 2px solid #75162d;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.3s;
        margin-bottom: 20px;
        font-family: inherit !important;
    }

    .btn-back-dashboard:hover {
        background-color: #75162d;
        color: #fff;
        text-decoration: none;
    }
/* Pagination */
.pagination-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:12px;
    margin-top:25px;
}

.page-btn{
    padding:10px 18px;
    background:#75162d;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-size:14px;
    font-weight:500;
    transition:.3s ease;
}

.page-btn:hover{
    background:#5a1122;
    transform:translateY(-1px);
}

.page-btn.disabled{
    background:#d1d5db;
    cursor:not-allowed;
    pointer-events:none;
}


</style>

<a href="/dashboard-pmik" class="btn-back-dashboard">
    ← Kembali ke Dashboard
</a>
<div class="container-pasien">
    <div class="card-pasien">

        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; font-family: inherit;">
                {{ session('success') }}
            </div>
        @endif

        <div class="header-pasien">
            <h2>Data Pasien</h2>

            <div class="actions">
                <a href="/pasien/create" class="btn-custom btn-add">+ Tambah Pasien</a>
                <input type="text" id="searchInput" class="search-box" placeholder="Cari pasien...">
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table-pasien" id="dataTable">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nomor RM</td>
                        <td>Nama Pasien</td>
                        <td>Jenis Kelamin</td>
                        <td>Usia</td>
                        <td>Alergi Obat</td>
                        <td>Detail</td>
                        <td>Aksi</td>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pasien as $item)
                    <tr>
                        <td>{{ $pasien->firstItem() + $loop->index }}</td>
                        <td>{{ $item->nomor_rm }}</td>
                        <td>{{ $item->nama_pasien }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->usia }} Thn</td>
                        <td>{{ $item->alergi_obat }}</td>

                        <td>
                        <button onclick="showDetail(
                         '{{ $item->nama_pasien }}',
                         '{{ $item->nomor_rm }}',
                         '{{ $item->jenis_kelamin }}',
                        '{{ $item->tempat_lahir }}',
                        '{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format("d-m-Y") }}',
                        '{{ $item->usia }}',
                        '{{ addslashes($item->alamat) }}',
                        '{{ $item->alergi_obat }}',
                        '{{ $item->status_asuransi ?? "-" }}',
                        '{{ addslashes($item->keterangan ?? "-") }}'
                         )" class="btn-custom btn-detail">
                        Lihat
                        </button>
                        </td>

                        <td>
                            <a href="/pasien/edit/{{ $item->id }}" class="btn-custom btn-edit">Edit</a>
                            <a href="/pasien/delete/{{ $item->id }}" class="btn-custom btn-delete" onclick="return confirm('Yakin ingin menghapus data {{ $item->nama_pasien }}?')">Hapus</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding: 30px; color: #888;">Belum ada data pasien yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
@if ($pasien->hasPages())
<div class="pagination-wrapper">
    @if ($pasien->onFirstPage())
        <span class="page-btn disabled">« Previous</span>
    @else
        <a href="{{ $pasien->previousPageUrl() }}" class="page-btn">
            « Previous
        </a>
    @endif

    @if ($pasien->hasMorePages())
        <a href="{{ $pasien->nextPageUrl() }}" class="page-btn">
            Next »
        </a>
    @else
        <span class="page-btn disabled">Next »</span>
    @endif
</div>
@endif
        </div>

    </div>
</div>

<div class="modal" id="detailModal">
    <div class="modal-content" style="max-width:520px; padding:30px;">
        <span class="close" onclick="closeModal()" style="font-size:24px; color:#999; position:absolute; top:15px; right:20px; cursor:pointer;">&times;</span>
        <h3 style="color:#75162d; font-size:18px; margin-bottom:15px; padding-bottom:12px; border-bottom:2px solid #eee;">
            Detail Lengkap Pasien
        </h3>
        <div id="detailContent" style="font-size:14px; color:#444; line-height:2;"></div>
    </div>
</div>

<script>
    // 3. MENYEMPURNAKAN JAVASCRIPT YANG TERPOTONG

    // Fitur Pencarian Real-time
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#dataTable tbody tr");

        rows.forEach(function(row){
            // Jangan filter baris "Belum ada data" jika tabel kosong
            if(row.children.length === 1) return; 
            
            let text = row.textContent.toLowerCase();
            // Menampilkan baris jika ada teks yang cocok, menyembunyikan jika tidak
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // Fitur Menampilkan Modal Detail
    function showDetail(nama, rm, jk, tempatLahir, tglLahir, usia, alamat, alergi, asuransi, ket) {
    
    // Warna badge alergi
    let alergiHtml = (alergi.toLowerCase() == 'tidak ada' || alergi == '-')
        ? '<span style="color:#888;">-</span>'
        : `<span style="color:#d9534f; font-weight:700;">${alergi}</span>`;

    // Warna badge asuransi
    let asuransiHtml = '';
    if (asuransi == 'BPJS' || asuransi == 'BPJS Kesehatan') {
        asuransiHtml = `<span style="background:#e8f5e9; color:#1b5e20; border:1px solid #2e7d32; padding:2px 12px; border-radius:20px; font-size:12px; font-weight:600;">🏥 ${asuransi}</span>`;
    } else if (asuransi == 'Umum') {
        asuransiHtml = `<span style="background:#e3f2fd; color:#0d47a1; border:1px solid #1565c0; padding:2px 12px; border-radius:20px; font-size:12px; font-weight:600;">👤 Umum</span>`;
    } else if (asuransi == 'Asuransi Swasta') {
        asuransiHtml = `<span style="background:#fff3cd; color:#856404; border:1px solid #ffc107; padding:2px 12px; border-radius:20px; font-size:12px; font-weight:600;">🏦 ${asuransi}</span>`;
    } else {
        asuransiHtml = '<span style="color:#888;">-</span>';
    }

    let content = `
        <div style="display:flex; margin-bottom:10px;">
            <div style="width:140px; font-weight:600; color:#555;">Nama</div>
            <div style="width:15px; color:#555;">:</div>
            <div style="flex:1;">${nama}</div>
        </div>
        <div style="display:flex; margin-bottom:10px;">
            <div style="width:140px; font-weight:600; color:#555;">No RM</div>
            <div style="width:15px; color:#555;">:</div>
            <div style="flex:1;">${rm}</div>
        </div>
        <div style="display:flex; margin-bottom:10px;">
            <div style="width:140px; font-weight:600; color:#555;">Jenis Kelamin</div>
            <div style="width:15px; color:#555;">:</div>
            <div style="flex:1;">${jk}</div>
        </div>
        <div style="display:flex; margin-bottom:10px;">
            <div style="width:140px; font-weight:600; color:#555;">TTL</div>
            <div style="width:15px; color:#555;">:</div>
            <div style="flex:1;">${tempatLahir}, ${tglLahir}</div>
        </div>
        <div style="display:flex; margin-bottom:10px;">
            <div style="width:140px; font-weight:600; color:#555;">Usia</div>
            <div style="width:15px; color:#555;">:</div>
            <div style="flex:1;">${usia} Tahun</div>
        </div>
        <div style="display:flex; margin-bottom:10px;">
            <div style="width:140px; font-weight:600; color:#555;">Alamat</div>
            <div style="width:15px; color:#555;">:</div>
            <div style="flex:1;">${alamat}</div>
        </div>
        <div style="display:flex; margin-bottom:10px;">
            <div style="width:140px; font-weight:600; color:#555;">Alergi Obat</div>
            <div style="width:15px; color:#555;">:</div>
            <div style="flex:1;">${alergiHtml}</div>
        </div>
        <div style="display:flex; margin-bottom:10px;">
            <div style="width:140px; font-weight:600; color:#555;">Jenis Asuransi</div>
            <div style="width:15px; color:#555;">:</div>
            <div style="flex:1;">${asuransiHtml}</div>
        </div>
        <div style="display:flex; margin-bottom:10px;">
            <div style="width:140px; font-weight:600; color:#555;">Keterangan</div>
            <div style="width:15px; color:#555;">:</div>
            <div style="flex:1; color:#888;">${ket}</div>
        </div>
    `;

    document.getElementById('detailContent').innerHTML = content;
    document.getElementById('detailModal').style.display = 'block';
}

    // Fitur Menutup Modal Detail
    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    // Menutup Modal jika user mengklik area di luar kotak modal
    window.onclick = function(event) {
        let modal = document.getElementById('detailModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection