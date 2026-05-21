@extends('dashboard-apoteker') 
@section('hide_search', true)

@section('content')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");

    :root{
        --primary:#75162d;
        --blue:#3498db;
        --orange:#f39c12;
        --red:#e74c3c;
    }

    .simora-container {
        width: 100%;
        margin: 0 auto;
        font-family: inherit !important;
    }

    .card-resep{
        background: #fff;
        padding: 25px;
        border-radius: 18px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .page-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .page-title{
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 5px;
    }

    .page-subtitle{
        color: #666;
        font-size: 14px;
    }

    .search-box input{
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #ddd;
        min-width: 220px;
        outline: none;
    }

    .alert-success{
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #c3e6cb;
    }

    .alert-danger{
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #f5c6cb;
    }

    .table-wrapper{
        overflow-x: auto;
    }

    .table-simora{
        width: 100%;
        border-collapse: collapse;
    }

    .table-simora thead{
        background: #f3f3f3;
    }

    .table-simora th{
        padding: 14px;
        font-weight: 700;
        text-align: center;
        color: #333;
        font-size: 14px;
        border: none;
        white-space: nowrap;
    }

    .table-simora td{
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        color: #444;
        vertical-align: middle;
    }
    .table-simora tbody tr:hover td {
    background-color: #5a1122;
    color: #fff;
    transition: 0.2s ease;
}

/* Semua teks biasa jadi putih saat hover */
.table-simora tbody tr:hover td,
.table-simora tbody tr:hover td strong,
.table-simora tbody tr:hover td small,
.table-simora tbody tr:hover td span,
.table-simora tbody tr:hover td li,
.table-simora tbody tr:hover td form,
.table-simora tbody tr:hover td a:not(.btn-aksi) {
    color: #fff !important;
}

/* Dosis/jumlah obat merah jadi putih saat hover */
.table-simora tbody tr:hover td span[style*="#75162d"] {
    color: #fff !important;
}

/* Auto BPJS jadi putih saat hover */
.table-simora tbody tr:hover small {
    color: #fff !important;
}

/* Badge yang punya background sendiri tetap normal */
.table-simora tbody tr:hover .badge-asuransi,
.table-simora tbody tr:hover .badge-umum,
.table-simora tbody tr:hover .badge-pending,
.table-simora tbody tr:hover .badge-diproses,
.table-simora tbody tr:hover .badge-selesai,
.table-simora tbody tr:hover .badge-habis,
.table-simora tbody tr:hover .stok-aman,
.table-simora tbody tr:hover .stok-menipis,
.table-simora tbody tr:hover .stok-habis,
.table-simora tbody tr:hover .btn-validasi,
.table-simora tbody tr:hover .btn-cetak {
    color: inherit !important;
}

/* Background badge & button tetap */
.table-simora tbody tr:hover .badge-asuransi {
    background:#e8f4fd !important;
    color:#1a6fa3 !important;
}

.table-simora tbody tr:hover .badge-umum {
    background:#f0f0f0 !important;
    color:#555 !important;
}

.table-simora tbody tr:hover .badge-pending {
    background:#ffc107 !important;
    color:#212529 !important;
}

.table-simora tbody tr:hover .badge-diproses {
    background:#0d6efd !important;
    color:#fff !important;
}

.table-simora tbody tr:hover .badge-selesai {
    background:#198754 !important;
    color:#fff !important;
}

.table-simora tbody tr:hover .badge-habis {
    background:#dc3545 !important;
    color:#fff !important;
}

.table-simora tbody tr:hover .stok-aman {
    background:#d4edda !important;
    color:#155724 !important;
}

.table-simora tbody tr:hover .stok-menipis {
    background:#fff3cd !important;
    color:#856404 !important;
}

.table-simora tbody tr:hover .stok-habis {
    background:#f8d7da !important;
    color:#721c24 !important;
}

.table-simora tbody tr:hover .btn-validasi {
    background:#28a745 !important;
    color:#fff !important;
}

.table-simora tbody tr:hover .btn-cetak {
    background:#75162d !important;
    color:#fff !important;
}

    .obat-list{
        margin: 0;
        padding-left: 0;
        list-style: none;
    }

    .obat-list li{
        margin-bottom: 6px;
        line-height: 1.4;
    }

    .badge-pending{
        background:#ffc107;
        color:#212529;
        padding:5px 12px;
        border-radius:20px;
        font-size:12px;
        font-weight:600;
    }

    .badge-diproses{
        background:#0d6efd;
        color:#fff;
        padding:5px 12px;
        border-radius:20px;
        font-size:12px;
        font-weight:600;
    }

    .badge-selesai{
        background:#198754;
        color:#fff;
        padding:5px 12px;
        border-radius:20px;
        font-size:12px;
        font-weight:600;
    }

    .badge-habis{
        background:#dc3545;
        color:#fff;
        padding:5px 12px;
        border-radius:20px;
        font-size:12px;
        font-weight:600;
    }

    .stok-aman{
        background:#d4edda;
        color:#155724;
        padding:2px 8px;
        border-radius:10px;
        font-size:11px;
        font-weight:600;
        display:inline-block;
        white-space:nowrap;
        margin-bottom:4px;
    }

    .stok-menipis{
        background:#fff3cd;
        color:#856404;
        padding:2px 8px;
        border-radius:10px;
        font-size:11px;
        font-weight:600;
        display:inline-block;
        white-space:nowrap;
        margin-bottom:4px;
    }

    .stok-habis{
        background:#f8d7da;
        color:#721c24;
        padding:2px 8px;
        border-radius:10px;
        font-size:11px;
        font-weight:600;
        display:inline-block;
        white-space:nowrap;
        margin-bottom:4px;
    }

    .badge-asuransi{
        background:#e8f4fd;
        color:#1a6fa3;
        padding:3px 10px;
        border-radius:10px;
        font-size:12px;
        font-weight:500;
    }

    .badge-umum{
        background:#f0f0f0;
        color:#555;
        padding:3px 10px;
        border-radius:10px;
        font-size:12px;
        font-weight:500;
    }

    .btn-aksi{
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 5px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        white-space: nowrap;
        color: white;
    }

    .btn-validasi{
        background:#28a745;
    }

    .btn-validasi:hover{
        background:#218838;
        color:#fff;
    }

    .btn-cetak{
        background:#75162d;
    }

    .btn-cetak:hover{
        background:#540816;
        color:#fff;
    }

    @media(max-width:768px){
        .page-header{
            flex-direction: column;
            align-items: flex-start;
        }

        .search-box input{
            width: 100%;
        }
    }

/* ================= PAGINATION CUSTOM ================= */

.custom-pagination{
    margin-top:25px;
    display:flex;
    justify-content:center;
}

.custom-pagination nav{
    display:flex;
    justify-content:center;
}

.custom-pagination ul{
    display:flex;
    align-items:center;
    gap:12px;
    padding:0;
    margin:0;
    list-style:none;
}

.custom-pagination li{
    list-style:none;
}

/* TOMBOL */
.custom-pagination .page-link{
    padding:10px 18px !important;
    border-radius:10px !important;
    border:none !important;
    background:#75162d !important;
    color:#fff !important;
    font-size:14px;
    font-weight:600;
    text-decoration:none !important;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    min-width:110px;
    transition:all .3s ease;
    box-shadow:none !important;
}

/* HOVER */
.custom-pagination .page-link:hover{
    background:#5a1122 !important;
    color:#fff !important;
    transform:translateY(-2px);
}

/* ACTIVE */
.custom-pagination .active .page-link{
    background:#5a1122 !important;
    color:#fff !important;
}

/* DISABLED */
.custom-pagination .disabled .page-link{
    background:#d1d5db !important;
    color:#6b7280 !important;
    cursor:not-allowed;
}

/* HILANGKAN BORDER BIRU BOOTSTRAP */
.custom-pagination .page-link:focus{
    box-shadow:none !important;
    outline:none !important;
}

/* FIX ICON PANAH */
.custom-pagination svg{
    width:14px !important;
    height:14px !important;
    flex-shrink:0;
}

</style>

<div class="simora-container">
    <div class="card-resep">

        <div class="page-header">
            <div>
                <h2 class="page-title">Daftar Resep Masuk</h2>
                <p class="page-subtitle">
                    Kelola dan siapkan obat berdasarkan resep dari dokter.
                </p>
            </div>

            <div class="search-box">
                <form method="GET" action="{{ route('apoteker.resep.index') }}">
                    <input type="text"
                           name="search"
                           placeholder="Cari resep..."
                           value="{{ request('search') }}">
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-danger">
                <strong>Gagal!</strong> {{ session('error') }}
            </div>
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
                        <th>Penebusan</th>
                        <th>Detail Obat </th>
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

                            $asuransi = $item->pasien->status_asuransi ?? 'Umum';

                            $isBPJS = in_array(strtolower($asuransi), [
                                'bpjs',
                                'bpjs kesehatan'
                            ]);

                            $obatDipilih = $item->obat_dipilih
                                ? array_map('strval', json_decode($item->obat_dipilih, true))
                                : [];
                        @endphp

                        <tr>

                            {{-- No --}}
                            <td>
                                {{ $data->firstItem() + $index }}
                            </td>

                            {{-- Tanggal --}}
                            <td style="white-space: nowrap;">
                                {{ \Carbon\Carbon::parse($item->tanggal_resep)->format('d M Y') }}
                            </td>

                            {{-- Pasien --}}
                            <td>
                                <strong>
                                    {{ $item->pasien->nama_pasien ?? 'Pasien Dihapus' }}
                                </strong>
                                <br>
                                <small style="color:#888;">
                                    {{ $item->diagnosa }}
                                </small>
                            </td>

                            {{-- Dokter --}}
                            <td>
                                {{ $item->nama_dokter }}
                            </td>

                            {{-- Asuransi --}}
                            <td>
                                @if($isBPJS)
                                    <span class="badge-asuransi">
                                        {{ $asuransi }}
                                    </span>

                                @elseif($asuransi && !in_array(strtolower($asuransi), ['umum', 'tidak ada', '-']))
                                    <span class="badge-asuransi">
                                        {{ $asuransi }}
                                    </span>

                                @else
                                    <span class="badge-umum">
                                        Umum
                                    </span>
                                @endif
                            </td>

                            {{-- Penebusan --}}
                            <td>
                                @if($isBPJS)

                                    <input type="checkbox"
                                           checked
                                           disabled
                                           style="width:18px; height:18px; accent-color:#0d6efd; cursor:not-allowed;">

                                    <small style="display:block; margin-top:3px;">
                                        Auto BPJS
                                    </small>

                                @else

                                    <form method="POST"
                                          action="{{ route('apoteker.resep.penebusan', $item->id) }}">

                                        @csrf

                                        <input type="checkbox"
                                               name="penebusan_obat"
                                               value="1"
                                               onchange="this.form.submit()"
                                               {{ $item->penebusan_obat ? 'checked' : '' }}
                                               style="width:18px; height:18px; cursor:pointer; accent-color:#0d6efd;">

                                    </form>

                                @endif
                            </td>

                            {{-- Detail Obat --}}
                            <td style="text-align:left;">
                                <ul class="obat-list">

                                    @foreach($obat_array as $key => $obat)

                                        @php
                                            $namaObat = trim($obat);
                                            $dosis    = trim($dosis_array[$key] ?? '-');
                                            $jumlah   = (int) trim($jumlah_array[$key] ?? 0);

                                            $dipilih  = in_array((string)$key, $obatDipilih);
                                        @endphp

                                        <li style="margin-bottom:8px; display:flex; align-items:center; gap:8px;">

                                            <form method="POST"
                                                  action="{{ route('apoteker.resep.pilihobat', $item->id) }}"
                                                  style="display:inline;">

                                                @csrf

                                                @foreach($obatDipilih as $idx)
                                                    @if((string)$idx !== (string)$key)
                                                        <input type="hidden"
                                                               name="obat_dipilih[]"
                                                               value="{{ $idx }}">
                                                    @endif
                                                @endforeach

                                                <input type="checkbox"
                                                       name="obat_dipilih[]"
                                                       value="{{ $key }}"
                                                       {{ $dipilih ? 'checked' : '' }}
                                                       onchange="this.form.submit()"
                                                       style="width:15px; height:15px; accent-color:#0d6efd; cursor:pointer; flex-shrink:0;">

                                            </form>

                                            <span>
                                                <strong>{{ $namaObat }}</strong>
                                                ({{ $dosis }})
                                                -
                                                <span style="color:#75162d; font-weight:bold;">
                                                    {{ $jumlah }} Pcs
                                                </span>
                                            </span>

                                        </li>

                                    @endforeach

                                </ul>
                            </td>

                            {{-- Stok --}}
                            <td>
                                <ul class="obat-list">

                                    @foreach($obat_array as $key => $obat)

                                        @php
                                            $namaObat = trim($obat);

                                            $obatData = $obats[$namaObat] ?? null;

                                            $stokDb = $obatData
                                                ? $obatData->stok
                                                : null;

                                            if ($stokDb === null) {
                                                $stokLabel = '<span class="stok-habis">Tidak Ditemukan</span>';
                                            } elseif ($stokDb <= 0) {
                                                $stokLabel = '<span class="stok-habis">Habis (0)</span>';
                                            } elseif ($stokDb <= 10) {
                                                $stokLabel = '<span class="stok-menipis">Menipis (' . $stokDb . ')</span>';
                                            } else {
                                                $stokLabel = '<span class="stok-aman">Tersedia (' . $stokDb . ')</span>';
                                            }
                                        @endphp

                                        <li style="margin-bottom:6px;">
                                            {!! $stokLabel !!}
                                        </li>

                                    @endforeach

                                </ul>
                            </td>

                            {{-- Status --}}
                            <td>

                                @if($item->status == 'Pending')

                                    <span class="badge-pending">
                                        Pending
                                    </span>

                                @elseif($item->status == 'Diproses')

                                    <span class="badge-diproses">
                                        Diproses
                                    </span>

                                @elseif($item->status == 'Selesai')

                                    <span class="badge-selesai">
                                        Selesai
                                    </span>

                                @else

                                    <span class="badge-habis">
                                        {{ $item->status }}
                                    </span>

                                @endif

                            </td>

                            {{-- Aksi --}}
                            <td>

                                @if($item->status != 'Selesai')

                                    <form method="POST"
                                          action="{{ route('resep.updateStatus', $item->id) }}"
                                          style="display:inline;">

                                        @csrf

                                        <input type="hidden"
                                               name="status"
                                               value="Selesai">

                                        <button type="submit"
                                                class="btn-aksi btn-validasi">
                                            ✔ Validasi Resep
                                        </button>

                                    </form>

                                @endif

                                @if($item->status == 'Selesai')

                                    <a href="{{ route('apoteker.resep.detail', $item->id) }}"
                                       class="btn-aksi btn-cetak">
                                        🖨 Cetak Salinan
                                    </a>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10"
                                style="padding:30px; color:#888; text-align:center;">
                                Belum ada data resep yang masuk.
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

      <div class="custom-pagination">
    {{ $data->links('pagination::simple-bootstrap-5') }}
</div>
    </div>
</div>
@endsection