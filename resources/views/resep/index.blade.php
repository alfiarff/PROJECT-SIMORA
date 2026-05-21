@extends('dashboard-dokter')

@section('hide_search', true)

@section('content')
<style>
    /* 1. VARIABEL WARNA DAN FONT MENGIKUTI TEMA SI-MORA */
    :root {
        --primary: #75162d; 
        --blue: #3498db;
        --orange: #f39c12;
        --red: #e74c3c;
    }

    .container-resep, 
    .container-resep h2, 
    .table-resep, 
    .table-resep th, 
    .table-resep td, 
    .btn-custom, 
    .search-box,
    .modal-content {
        font-family: inherit !important;
    }

    .container-resep {
        width: 100%;
        margin: 0 auto;
    }

    .card-resep {
        background: #fff;
        padding: 25px;
        border-radius: 18px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .header-resep {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .header-resep h2 {
        color: var(--primary);
    }

    .actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-box {
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #ddd;
        min-width: 220px;
    }

    .btn-custom {
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

    /* WARNA TOMBOL */
    .btn-add { background: var(--primary); }
    .btn-add:hover { background: #5a1122; }
    
    .btn-detail { background: var(--blue); }
    .btn-edit { background: var(--orange); }
    .btn-delete { background: var(--red); }

    .table-wrapper {
        overflow-x: auto;
    }

    .table-resep {
        width: 100%;
        border-collapse: collapse;
    }

    .table-resep thead {
        background: #f3f3f3;
    }

    .table-resep thead td {
        padding: 14px;
        font-weight: 700;
        text-align: center;
        color: #333;
    }

    .table-resep tbody td {
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    /* Efek Hover Tabel */
    .table-resep tbody tr:hover {
        background: var(--primary);
        color: white;
        transition: .3s;
    }

    .table-resep tbody tr:hover a,
    .table-resep tbody tr:hover button {
        opacity: 0.95;
    }

    /* CSS Untuk Modal Detail */
    .modal {
        display: none;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.55);
        z-index: 9999;
    }

    .modal-content {
        background: white;
        width: 95%;
        max-width: 500px;
        margin: 10% auto;
        border-radius: 15px;
        padding: 25px;
        position: relative;
    }

    .close {
        position: absolute;
        top: 12px;
        right: 16px;
        font-size: 26px;
        cursor: pointer;
        color: #333;
    }

    .modal-content h3 {
        color: var(--primary);
        margin-bottom: 15px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .modal-content p {
        line-height: 1.8;
        color: #444;
    }

    @media(max-width:768px) {
        .header-resep { flex-direction: column; align-items: flex-start; }
        .actions { width: 100%; flex-direction: column; }
        .search-box { width: 100%; }
    }
/* ================= PAGINATION CUSTOM ================= */

.custom-pagination {
    display: flex;
    justify-content: center;
    margin-top: 25px;
}

.custom-pagination .pagination {
    gap: 12px;
}

.custom-pagination .page-item .page-link {
    padding: 10px 18px;
    background: #75162d;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: .3s ease;
    box-shadow: none;
}

.custom-pagination .page-item .page-link:hover {
    background: #5a1122;
    color: #fff;
    transform: translateY(-1px);
}

.custom-pagination .page-item.active .page-link {
    background: #5a1122;
    color: #fff;
    border: none;
}

.custom-pagination .page-item.disabled .page-link {
    background: #d1d5db;
    color: #6b7280;
    border: none;
    cursor: not-allowed;
}

.custom-pagination .page-link:focus {
    box-shadow: none;
}
</style>

<div class="container-resep">
    <div class="card-resep">

        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; font-family: inherit;">
                {{ session('success') }}
            </div>
        @endif

        <div class="header-resep">
            <div>
                <h2 style="color:#5a1122; font-weight:700; margin-bottom:5px;">
                    Data Resep Pasien
                </h2>

                <p style="margin:0; color:#777; font-size:14px; font-weight:400;">
                    Kelola dan buat resep obat untuk pasien berdasarkan hasil pemeriksaan.
                </p>
            </div>

            <div class="actions">
                {{-- Tombol Tambah Resep Disembunyikan --}}
                {{-- 
            <a href="/resep/create?pasien_id={{ $pasien->id }}" class="btn-kembali" style="background-color: #28a745; margin-top: 0;">
            + Tambah Resep
            </a> 
                --}}

                <input type="text"
                    id="searchInput"
                    class="search-box"
                    placeholder="Cari resep...">
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table-resep" id="dataTable">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Tanggal</td>
                        <td>No RM</td>
                        <td>Nama Pasien</td>
                        <td>Dokter</td>
                        <td>Detail</td>
                        <td>Aksi</td>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_resep)->format('d/m/Y') }}</td>
                        <td>{{ $item->pasien->nomor_rm ?? '-' }}</td>
                        <td>{{ $item->pasien->nama_pasien ?? '-' }}</td>
                        <td>{{ $item->nama_dokter }}</td>

                        <td>
                            <!-- Memanggil modal detail dengan data resep -->
                            <button class="btn-custom btn-detail" onclick="showDetail(
                                '{{ $item->pasien->nama_pasien ?? '-' }}',
                                '{{ $item->pasien->nomor_rm ?? '-' }}',
                                '{{ \Carbon\Carbon::parse($item->tanggal_resep)->format('d M Y') }}',
                                '{{ $item->nama_dokter }}',
                                '{{ $item->nama_obat }}',
                                '{{ $item->dosis_obat }}',
                                '{{ $item->diagnosa ?? '-' }}',
                                '{{ $item->keterangan ?? '-' }}'
                            )">Lihat</button>
                        </td>

                        <td>
                            <a href="/resep/edit/{{ $item->id }}" class="btn-custom btn-edit">Edit</a>
                            <a href="/resep/delete/{{ $item->id }}" class="btn-custom btn-delete" onclick="return confirm('Yakin ingin menghapus resep untuk pasien {{ $item->pasien->nama_pasien ?? '' }}?')">Hapus</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding: 30px; color: #888;">Belum ada data resep yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
                        {{-- Pagination --}}
            <div class="custom-pagination">
                {{ $data->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>

    </div>
</div>

<!-- Modal Pop-up Detail Resep -->
<div class="modal" id="detailModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Detail Lengkap Resep</h3>
        <div id="detailContent"></div>
    </div>
</div>

<script>
    // Fitur Pencarian Real-time
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#dataTable tbody tr");

        rows.forEach(function(row){
            // Jangan filter baris "Belum ada data" jika tabel kosong
            if(row.children.length === 1) return; 
            
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // Fitur Menampilkan Modal Detail
    function showDetail(namaPasien, noRm, tglResep, namaDokter, obat, dosis, diagnosa, keterangan) {
        let content = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; margin-bottom: 15px;">
                <div>
                    <strong>Tanggal:</strong> <br>${tglResep}
                </div>
                <div>
                    <strong>Dokter:</strong> <br>${namaDokter}
                </div>
            </div>
            <div style="background: #f9f9f9; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
                <strong>Pasien:</strong> ${namaPasien} (${noRm})
            </div>
            <div style="border-top: 1px dashed #ccc; padding-top: 15px;">
                <strong>Diagnosa:</strong> <br>${diagnosa} <br><br>
                <strong>Daftar Obat:</strong> <br>${obat} <br><br>
                <strong>Aturan Pakai / Dosis:</strong> <br>${dosis} <br><br>
                <strong>Catatan Tambahan:</strong> <br>${keterangan}
            </div>
        `;
        document.getElementById('detailContent').innerHTML = content;
        document.getElementById('detailModal').style.display = 'block';
    }

    // Fitur Menutup Modal Detail
    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    // Menutup Modal jika user mengklik area abu-abu di luar kotak modal
    window.onclick = function(event) {
        let modal = document.getElementById('detailModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection