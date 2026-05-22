@extends('dashboard-apoteker') 
@section('hide_search', true)
@section('content')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");

    .simora-container {
        font-family: "Poppins", sans-serif;
        padding: 25px; 
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin: 10px 0; 
        width: 100%;
        box-sizing: border-box; 
        min-height: calc(100vh - 110px);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-title { 
        color: #75162d; 
        font-size: 24px;
        font-weight: 700; 
        margin-bottom: 5px; 
    }
    
    .page-subtitle { 
        color: #666; 
        font-size: 14px; 
    }

    .search-box input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        width: 250px;
        outline: none;
        transition: 0.3s;
    }

    .search-box input:focus {
        border-color: #75162d;
        box-shadow: 0 0 5px rgba(117, 22, 45, 0.2);
    }

    .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    .alert-danger  { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .table-simora { 
        width: 100%; 
        border-collapse: collapse; 
    }

    .table-simora thead tr {
        background-color: #f8f9fa; 
        border-bottom: 2px solid #eee;
    }

    .table-simora th {
        color: #333;
        padding: 12px 10px; 
        text-align: center;
        font-size: 13px; 
        font-weight: 600;
        white-space: nowrap;
    }

    .table-simora td {
        padding: 15px 10px; 
        border-bottom: 1px solid #eee;
        font-size: 13px;
        color: #444;
        vertical-align: middle;
        text-align: center;
    }

    .table-simora th:nth-child(3), .table-simora td:nth-child(3),
    .table-simora th:nth-child(6), .table-simora td:nth-child(6),
    .table-simora th:nth-child(7), .table-simora td:nth-child(7) {
        text-align: left;
    }

    /* --- BADGES --- */
    .obat-list { margin: 0; padding-left: 0; list-style: none; }
    .obat-list li { margin-bottom: 8px; line-height: 1.4; }

    .badge-pending   { background:#ffc107; color:#212529; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; display:inline-block; }
    .badge-diproses  { background:#0d6efd; color:#fff;    padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; display:inline-block; }
    .badge-selesai   { background:#198754; color:#fff;    padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; display:inline-block; }
    .badge-habis     { background:#dc3545; color:#fff;    padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; display:inline-block; }

    .stok-aman    { background:#d4edda; color:#155724; padding:3px 10px; border-radius:10px; font-size:11px; font-weight:600; display:inline-block; white-space:nowrap; margin-bottom:4px; }
    .stok-menipis { background:#fff3cd; color:#856404; padding:3px 10px; border-radius:10px; font-size:11px; font-weight:600; display:inline-block; white-space:nowrap; margin-bottom:4px; }
    .stok-habis   { background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:10px; font-size:11px; font-weight:600; display:inline-block; white-space:nowrap; margin-bottom:4px; }

    .badge-asuransi { background:#e8f4fd; color:#1a6fa3; padding:4px 12px; border-radius:12px; font-size:12px; font-weight:600; display:inline-block; }
    .badge-umum     { background:#f0f0f0; color:#555;    padding:4px 12px; border-radius:12px; font-size:12px; font-weight:600; display:inline-block; }

    /* --- BUTTONS DEFAULT --- */
    .btn-aksi {
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 5px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-aksi.btn-validasi {
        background: #28a745;
        color: #fff;
    }
    .btn-aksi.btn-validasi:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(40,167,69,0.4);
    }

    .btn-aksi.btn-cetak {
        background: #75162d;
        color: #fff;
    }
    .btn-aksi.btn-cetak:hover {
        background: #540816;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(117,22,45,0.4);
    }

    /* === HOVER BARIS TABEL === */
    .table-simora tbody tr {
        transition: background-color 0.2s ease;
    }

    .table-simora tbody tr:hover {
        background-color: #5a1122;
    }

    .table-simora tbody tr:hover td,
    .table-simora tbody tr:hover td span,
    .table-simora tbody tr:hover td strong {
        color: #fff !important;
    }

    /* Badge saat hover */
    .table-simora tbody tr:hover .badge-asuransi { background:#3b82f6 !important; color:#fff !important; }
    .table-simora tbody tr:hover .badge-umum     { background:#6b7280 !important; color:#fff !important; }
    .table-simora tbody tr:hover .badge-pending  { background:#f59e0b !important; color:#fff !important; }
    .table-simora tbody tr:hover .badge-diproses { background:#3b82f6 !important; color:#fff !important; }
    .table-simora tbody tr:hover .badge-selesai  { background:#10b981 !important; color:#fff !important; }
    .table-simora tbody tr:hover .badge-habis    { background:#ef4444 !important; color:#fff !important; }
    .table-simora tbody tr:hover .stok-aman      { background:#10b981 !important; color:#fff !important; }
    .table-simora tbody tr:hover .stok-menipis   { background:#f59e0b !important; color:#fff !important; }
    .table-simora tbody tr:hover .stok-habis     { background:#ef4444 !important; color:#fff !important; }

    /* Tombol saat hover baris — warna tetap sama */
    .table-simora tbody tr:hover .btn-aksi.btn-validasi { background:#28a745 !important; color:#fff !important; }
    .table-simora tbody tr:hover .btn-aksi.btn-cetak    { background:#75162d !important; color:#fff !important; }

    /* ================= PAGINATION ================= */
    .custom-pagination { margin-top:25px; display:flex; justify-content:center; }
    .custom-pagination nav { display:flex; justify-content:center; }
    .custom-pagination ul { display:flex; align-items:center; gap:12px; padding:0; margin:0; list-style:none; }
    .custom-pagination li { list-style:none; }
    .custom-pagination .page-link { padding:10px 18px !important; border-radius:10px !important; border:none !important; background:#75162d !important; color:#fff !important; font-size:14px; font-weight:600; text-decoration:none !important; display:flex; align-items:center; justify-content:center; gap:6px; min-width:110px; transition:all .3s ease; box-shadow:none !important; }
    .custom-pagination .page-link:hover { background:#5a1122 !important; color:#fff !important; transform:translateY(-2px); }
    .custom-pagination .active .page-link { background:#5a1122 !important; color:#fff !important; }
    .custom-pagination .disabled .page-link { background:#d1d5db !important; color:#6b7280 !important; cursor:not-allowed; }
    .custom-pagination .page-link:focus { box-shadow:none !important; outline:none !important; }
    .custom-pagination svg { width:14px !important; height:14px !important; flex-shrink:0; }
</style>

<div class="simora-container">
    <div class="page-header">
        <div>
            <h2 class="page-title">Daftar Resep Masuk</h2>
            <p class="page-subtitle">Kelola dan siapkan obat berdasarkan resep dari dokter.</p>
        </div>
        <div class="search-box">
            <form method="GET" action="{{ route('apoteker.resep.index') }}">
                <input type="text" name="search" placeholder="Cari resep..." value="{{ request('search') }}">
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success"><strong>Berhasil!</strong> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-danger"><strong>Gagal!</strong> {{ session('error') }}</div>
    @endif

    <div class="table-wrapper">
        <table class="table-simora">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pasien & Diagnosa</th>
                    <th>Dokter</th>
                    <th>Asuransi</th>
                    <th>Detail Obat (Nama - Dosis - Jumlah)</th>
                    <th>Stok Obat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                    @php
                        $obat_array   = explode(',', $item->nama_obat);
                        $dosis_array  = explode(',', $item->dosis_obat);
                        $jumlah_array = explode(',', $item->jumlah);
                        $asuransi     = $item->pasien->status_asuransi ?? 'Umum';
                        $isBPJS       = in_array(strtolower($asuransi), ['bpjs', 'bpjs kesehatan']);
                        $obatDipilih  = $item->obat_dipilih
                                        ? array_map('strval', json_decode($item->obat_dipilih, true))
                                        : [];
                    @endphp
                    <tr>
                        {{-- No --}}
                        <td>{{ $data->firstItem() + $index }}</td>

                        {{-- Tanggal --}}
                        <td style="white-space:nowrap; font-weight:500;">
                            {{ \Carbon\Carbon::parse($item->tanggal_resep)->format('d M Y') }}
                        </td>

                        {{-- Pasien & Diagnosa --}}
                        <td>
                            <strong style="color: #111; font-size: 14px;">{{ $item->pasien->nama_pasien ?? 'Pasien Dihapus' }}</strong><br>
                            <span style="color:#777; font-size: 12px;">{{ $item->diagnosa }}</span>
                        </td>

                        {{-- Dokter --}}
                        <td style="font-size:13px; font-weight:500; color:#555;">{{ $item->nama_dokter }}</td>

                        {{-- Asuransi --}}
                        <td>
                            @if($isBPJS)
                                <span class="badge-asuransi">{{ $asuransi }}</span>
                            @elseif($asuransi && !in_array(strtolower($asuransi), ['umum', 'tidak ada', '-']))
                                <span class="badge-asuransi">{{ $asuransi }}</span>
                            @else
                                <span class="badge-umum">Umum</span>
                            @endif
                        </td>

                        {{-- Detail Obat + Checkbox (Otomatis & Terkunci untuk BPJS) --}}
                        <td>
                            <ul class="obat-list">
                                @foreach($obat_array as $key => $obat)
                                    @php
                                        $namaObat = trim($obat);
                                        $dosis    = trim($dosis_array[$key] ?? '-');
                                        $jumlah   = (int) trim($jumlah_array[$key] ?? 0);
                                        $dipilih  = in_array((string)$key, $obatDipilih);
                                    @endphp
                                    <li style="display:flex; align-items:center; gap:10px;">
                                            <form method="POST" action="{{ route('apoteker.resep.pilihobat', $item->id) }}" style="display:inline;">
                                                @csrf
                                                @foreach($obatDipilih as $idx)
                                                    @if((string)$idx !== (string)$key)
                                                        <input type="hidden" name="obat_dipilih[]" value="{{ $idx }}">
                                                    @endif
                                                @endforeach
                                                <input type="checkbox"
                                                       name="obat_dipilih[]"
                                                       value="{{ $key }}"
                                                       {{ $dipilih ? 'checked' : '' }}
                                                       onchange="this.form.submit()"
                                                       style="width:16px; height:16px; accent-color:#0d6efd; cursor:pointer; flex-shrink:0;">
                                            </form>                                        
                                        <span>
                                            <strong style="color: #222;">{{ $namaObat }}</strong>
                                            <span style="color: #666;">({{ $dosis }})</span> - <span style="color:#75162d; font-weight:600;">{{ $jumlah }} Pcs</span>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        {{-- Stok Obat --}}
                        <td>
                            <ul class="obat-list">
                                @foreach($obat_array as $key => $obat)
                                    @php
                                        $namaObat = trim($obat);
                                        $obatData = $obats[$namaObat] ?? null;
                                        $stokDb   = $obatData ? $obatData->stok : null;

                                        if ($stokDb === null) {
                                            $stokLabel = '<span class="stok-habis">Tidak Ada</span>';
                                        } elseif ($stokDb <= 0) {
                                            $stokLabel = '<span class="stok-habis">Habis (0)</span>';
                                        } elseif ($stokDb <= 10) {
                                            $stokLabel = '<span class="stok-menipis">Menipis (' . $stokDb . ')</span>';
                                        } else {
                                            $stokLabel = '<span class="stok-aman">Tersedia (' . $stokDb . ')</span>';
                                        }
                                    @endphp
                                    <li>{!! $stokLabel !!}</li>
                                @endforeach
                            </ul>
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($item->status == 'Pending')
                                <span class="badge-pending">Pending</span>
                            @elseif($item->status == 'Diproses')
                                <span class="badge-diproses">Diproses</span>
                            @elseif($item->status == 'Selesai')
                                <span class="badge-selesai">Selesai</span>
                            @else
                                <span class="badge-habis">{{ $item->status }}</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td>
                            @if($item->status != 'Selesai')
                                <form method="POST" action="{{ route('resep.updateStatus', $item->id) }}" style="display:inline; margin-bottom:5px;">
                                    @csrf
                                    <input type="hidden" name="status" value="Selesai">
                                    <button type="submit" class="btn-aksi btn-validasi">✔ Validasi Resep</button>
                                </form>
                            @endif

                            @if($item->status == 'Selesai')
                                <a href="{{ route('apoteker.resep.detail', $item->id) }}" class="btn-aksi btn-cetak">
                                    🖨 Cetak Salinan
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:40px; color:#999; font-size:14px;">
                            Belum ada data resep yang masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ MENGGUNAKAN CUSTOM PAGINATION DARI KODE 2 --}}
    <div class="custom-pagination">
        {{ $data->links('pagination::simple-bootstrap-5') }}
    </div>
</div>
@endsection