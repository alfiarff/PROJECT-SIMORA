@extends('dashboard-dokter')
@section('hide_search', false)
@section('content')
<style>
    .container-pasien {
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin: auto;
        width: 100%;
    }

    .header-pasien {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header-pasien h2 {
        color: #75162d;
        font-size: 24px;
        margin: 0;
    }

    .search-box {
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        width: 250px;
        outline: none;
    }

    .table-pasien {
        width: 100%;
        border-collapse: collapse;
    }

    .table-pasien thead tr {
        background-color: #f8f9fa;
        border-bottom: 2px solid #eee;
    }

    .table-pasien th, .table-pasien td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #eee;
        color: #333;
    }

    .table-pasien th {
        font-weight: 600;
        color: #000;
    }

    .table-pasien tbody tr:hover {
        background: #5a1122;
    }

    .table-pasien tbody tr {
        transition: all 0.2s ease;
    }

    .table-pasien tbody tr:hover {
        background: #5a1122;
    }

    /* teks jadi putih saat hover */
    .table-pasien tbody tr:hover td {
        color: #fff;
    }

    /* biar tombol tetap jelas */
    .table-pasien tbody tr:hover .btn {
        color: #fff;
    }

    /* --- PERBAIKAN CSS BUTTON (AKSI) --- */
    .btn {
        padding: 8px 14px;
        border-radius: 6px;
        text-decoration: none;
        color: white;
        font-size: 13px;
        font-weight: 500;
        display: inline-block;
        margin: 0 4px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease; /* Transisi halus */
    }

    /* Tombol Lihat (Biru) */
    .btn-lihat { 
        background-color: #5b9bd5; 
    }

    .btn-lihat:hover{
        background-color:#5b9bd5 !important;
        color:#fff !important;
        transform:none !important;
        box-shadow:none !important;
    }

    .table-pasien tbody tr:hover .btn-lihat{
        background:#5b9bd5 !important;
        color:#fff !important;
    }

    /* Tombol Tambah Resep (Hijau) */
    .btn-resep { 
        background-color: #28a745; 
    }
    .btn-resep:hover { 
        background-color: #218838; /* Hijau lebih gelap */
        transform: translateY(-2px); /* Efek terangkat */
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.4); /* Bayangan hijau */
    }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.55);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal-box {
        background: #fff;
        width: 95%;
        max-width: 520px;
        border-radius: 15px;
        padding: 30px;
        position: relative;
        animation: fadeInUp 0.3s ease;
    }

    .modal-box h3 {
        color: #75162d;
        font-size: 18px;
        margin-bottom: 15px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eee;
    }

    .modal-close {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 24px;
        color: #999;
        cursor: pointer;
        background: none;
        border: none;
        line-height: 1;
    }

    .modal-close:hover { color: #333; }

    .detail-row {
        display: flex;
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 1.6;
    }

    .detail-label {
        width: 140px;
        font-weight: 600;
        color: #555;
        flex-shrink: 0;
    }

    .detail-colon {
        width: 15px;
        color: #555;
    }

    .detail-value {
        flex: 1;
        color: #222;
    }

    @keyframes fadeInUp {
        from { transform: translateY(30px); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
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

<div class="container-pasien">
<div class="header-pasien">
    <div>
        <h2 style="color:#5a1122; font-weight:700; margin-bottom:5px;">
            Data Pasien
        </h2>

        <p style="margin:0; color:#777; font-size:14px; font-weight:400;">
            Lihat data pasien dan lakukan proses peresepan obat sesuai kebutuhan pelayanan.
        </p>
    </div>

    <input type="text"
           id="searchInput"
           class="search-box"
           placeholder="Cari pasien...">
</div>

    <table class="table-pasien" id="dataTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor RM</th>
                <th>Nama Pasien</th>
                <th>Jenis Kelamin</th>
                <th>Usia</th>
                <th>Alergi Obat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pasiens as $key => $p)
            <tr>
                <td>{{ $pasiens->firstItem() + $key }}</td>
                <td>{{ $p->nomor_rm }}</td>
                <td>{{ $p->nama_pasien }}</td>
                <td>{{ $p->jenis_kelamin }}</td>
                <td>{{ $p->usia }} Tahun</td>
                <td>{{ $p->alergi_obat ?? '-' }}</td>
                <td>
                    {{-- ✅ Tombol Lihat → buka modal --}}
                    <button onclick="showDetail(
                        '{{ $p->nama_pasien }}',
                        '{{ $p->nomor_rm }}',
                        '{{ $p->jenis_kelamin }}',
                        '{{ $p->tempat_lahir ?? "-" }}',
                        '{{ \Carbon\Carbon::parse($p->tanggal_lahir)->format("d-m-Y") }}',
                        '{{ $p->usia }}',
                        '{{ addslashes($p->alamat) }}',
                        '{{ $p->alergi_obat ?? "-" }}',
                        '{{ $p->status_asuransi ?? "-" }}',
                        '{{ addslashes($p->keterangan ?? "-") }}'
                    )" class="btn btn-lihat">Lihat</button>

                    @if($p->resep->isEmpty())
                        <a href="/resep/create?pasien_id={{ $p->id }}" class="btn btn-resep">+ Tambah Resep</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding:30px; color:#888;">Belum ada data pasien.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
     <div class="custom-pagination">
    {{ $pasiens->links('pagination::simple-bootstrap-5') }}
</div>
</div>



{{-- ✅ Modal Detail Pasien --}}
<div class="modal-overlay" id="detailModal">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal()">&times;</button>
        <h3>Detail Lengkap Pasien</h3>
        <div id="detailContent"></div>
    </div>
</div>


<script>
    // Search real-time
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#dataTable tbody tr');
        rows.forEach(function(row) {
            if (row.children.length === 1) return;
            row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    function showDetail(nama, rm, jk, tempatLahir, tglLahir, usia, alamat, alergi, asuransi, ket) {

        let alergiHtml = (alergi.toLowerCase() == 'tidak ada' || alergi == '-')
            ? '<span style="color:#888;">-</span>'
            : `<span style="color:#d9534f; font-weight:700;">${alergi}</span>`;

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

        document.getElementById('detailContent').innerHTML = `
            <div class="detail-row">
                <div class="detail-label">Nama</div>
                <div class="detail-colon">:</div>
                <div class="detail-value">${nama}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">No RM</div>
                <div class="detail-colon">:</div>
                <div class="detail-value">${rm}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jenis Kelamin</div>
                <div class="detail-colon">:</div>
                <div class="detail-value">${jk}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">TTL</div>
                <div class="detail-colon">:</div>
                <div class="detail-value">${tempatLahir}, ${tglLahir}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Usia</div>
                <div class="detail-colon">:</div>
                <div class="detail-value">${usia} Tahun</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Alamat</div>
                <div class="detail-colon">:</div>
                <div class="detail-value">${alamat}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Alergi Obat</div>
                <div class="detail-colon">:</div>
                <div class="detail-value">${alergiHtml}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jenis Asuransi</div>
                <div class="detail-colon">:</div>
                <div class="detail-value">${asuransiHtml}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Keterangan</div>
                <div class="detail-colon">:</div>
                <div class="detail-value" style="color:#888;">${ket}</div>
            </div>
        `;

        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    // Klik di luar modal = tutup
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection