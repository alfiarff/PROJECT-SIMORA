@extends('dashboard-apoteker')
@section('hide_search', true)

@section('content')
<style>
    :root{
        --primary:#560b18;
        --success:#198754;
        --warning:#ffc107;
        --danger:#dc3545;
    }

    .container-stok,
    .container-stok h2,
    .table-stok,
    .table-stok th,
    .table-stok td,
    .btn-custom,
    .modal-content{
        font-family: inherit !important;
    }

    .container-stok{
        width:100%;
        margin:0 auto;
    }

    .card-stok{
        background:#fff;
        padding:25px;
        border-radius:18px;
        box-shadow:0 10px 25px rgba(0,0,0,0.08);
    }

    .header-stok{
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:15px;
        margin-bottom:20px;
    }

    .header-stok h2{
        color:#75162d;
        font-weight:700;
        margin:0;
    }

    .btn-custom{
        text-decoration:none;
        border:none;
        padding:10px 16px;
        border-radius:8px;
        color:white;
        cursor:pointer;
        font-size:14px;
        font-weight:500;
        transition:0.3s;
    }

    .btn-add{
        background:#75162d;
    }

    .btn-add:hover{
        background:#5a1122;
    }

    .btn-edit{
        background:#fd7e14;
        color:#fff;
    }

    .btn-edit:hover{
        background:var(--orange);
    }

    .table-wrapper{
        overflow-x:auto;
    }

    .table-stok{
        width:100%;
        border-collapse:collapse;
    }

    .table-stok thead{
        background:#f3f3f3;
    }

    .table-stok thead td{
        padding:14px;
        font-weight:700;
        text-align:center;
        color:#333;
    }

    .table-stok tbody td{
        padding:14px;
        text-align:center;
        border-bottom:1px solid #eee;
        vertical-align:middle;
    }

    .table-stok tbody tr:hover{
        background:#5a1122;
        transition:.3s;
    }

    .table-stok tbody tr:hover td{
        background:#5a1122;
        color:#fff;
    }

    /* Badge tetap normal walau hover */
    .table-stok tbody tr:hover .badge-status{
        color:inherit !important;
    }

    .table-stok tbody tr:hover .status-aman{
        background:#d4edda !important;
        color:#155724 !important;
    }

    .table-stok tbody tr:hover .status-menipis{
        background:#fff3cd !important;
        color:#856404 !important;
    }

    .table-stok tbody tr:hover .status-habis{
        background:#f8d7da !important;
        color:#721c24 !important;
    }

    /* Jumlah stok maroon jadi putih saat hover */
    .table-stok tbody tr:hover td span{
        color:#fff !important;
    }

    /* Nama obat jadi putih saat hover */
    .table-stok tbody tr:hover td[style*="#333"]{
        color:#fff !important;
    }

    /* Button edit tetap punya warna sendiri */
    .table-stok tbody tr:hover .btn-edit{
        background:#fd7e14 !important;
        color:#fff !important;
    }

    .badge-status{
        padding:5px 12px;
        border-radius:20px;
        font-size:12px;
        font-weight:600;
        display:inline-block;
    }

    .status-aman{
        background:#d4edda;
        color:#155724;
    }

    .status-menipis{
        background:#fff3cd;
        color:#856404;
    }

    .status-habis{
        background:#f8d7da;
        color:#721c24;
    }

    .modal-content{
        border-radius:15px;
        border:none;
        overflow:hidden;
    }

    .modal-header{
        background:#75162d;
        color:white;
        border-bottom:none;
    }

    .modal-title{
        font-weight:700;
    }

    .form-control,
    .form-select{
        border-radius:8px;
        padding:10px 14px;
    }

    .btn-modal{
        background:#75162d;
        color:white;
        border:none;
        border-radius:8px;
        padding:10px 22px;
        font-weight:600;
    }

    .btn-modal:hover{
        background:#5a1122;
        color:white;
    }

    @media(max-width:768px){
        .header-stok{
            flex-direction:column;
            align-items:flex-start;
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
    padding:10px 20px !important;
    border:none !important;
    border-radius:10px !important;
    background:#75162d !important;
    color:#fff !important;
    font-size:14px;
    font-weight:600;
    text-decoration:none !important;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:all .3s ease;
    min-width:120px;
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

/* HILANGKAN BORDER BIRU */
.custom-pagination .page-link:focus{
    box-shadow:none !important;
    outline:none !important;
}

/* ICON PANAH */
.custom-pagination svg{
    width:14px !important;
    height:14px !important;
    flex-shrink:0;
}
</style>

<div class="container-stok">
    <div class="card-stok">

        @if(session('success'))
            <div style="background-color:#d4edda; color:#155724; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        <div class="header-stok">
            <h2>Data Stok Obat</h2>

            <button type="button"
                    class="btn-custom btn-add"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambahObat">
                + Tambah Obat
            </button>
        </div>

        <div class="table-wrapper">
            <table class="table-stok">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama Obat</td>
                        <td>Satuan</td>
                        <td>Sisa Stok</td>
                        <td>Status</td>
                        <td>Aksi</td>
                    </tr>
                </thead>

                <tbody>
                    @forelse($obats as $index => $obat)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td style="color:#333;">
                            {{ $obat->nama_obat }}
                        </td>

                        <td>
                            {{ $obat->satuan ?? '-' }}
                        </td>

                        <td>
                            <span style="color:#000;">
                                {{ $obat->stok }}
                            </span>
                        </td>

                        <td>
                            @if($obat->stok >= 10)
                                <span class="badge-status status-aman">
                                    Tersedia
                                </span>

                            @elseif($obat->stok > 0 && $obat->stok < 10)
                                <span class="badge-status status-menipis">
                                    Menipis
                                </span>

                            @else
                                <span class="badge-status status-habis">
                                    Habis
                                </span>
                            @endif
                        </td>

                        <td>
                            <button type="button"
                                    class="btn-custom btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditObat{{ $obat->id }}">
                                Edit
                            </button>
                        </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade"
                         id="modalEditObat{{ $obat->id }}"
                         tabindex="-1"
                         aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Edit Stok: {{ $obat->nama_obat }}
                                    </h5>

                                    <button type="button"
                                            class="btn-close btn-close-white"
                                            data-bs-dismiss="modal">
                                    </button>
                                </div>

                                <form action="{{ route('apoteker.stok.update', $obat->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('PUT')

                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Jumlah Stok Terbaru
                                            </label>

                                            <input type="number"
                                                   name="stok"
                                                   value="{{ $obat->stok }}"
                                                   class="form-control"
                                                   min="0"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-0 px-4 pb-4">
                                        <button type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">
                                            Batal
                                        </button>

                                        <button type="submit"
                                                class="btn-modal">
                                            Simpan Perubahan
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="6"
                            style="padding:30px; color:#888;">
                            Belum ada data obat di database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
           <div class="custom-pagination">
    {{ $obats->links('pagination::simple-bootstrap-5') }}
</div>
        </div>

    </div>
</div>

{{-- Modal Tambah Obat --}}
<div class="modal fade"
     id="modalTambahObat"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Tambah Stok Obat Baru
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form action="{{ route('apoteker.stok.store') }}"
                  method="POST">

                @csrf

                <div class="modal-body p-4">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Obat
                        </label>

                        <input type="text"
                               name="nama_obat"
                               class="form-control"
                               placeholder="Contoh: Amoxicillin 500mg"
                               required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Satuan
                            </label>

                            <select name="satuan"
                                    class="form-select"
                                    required>

                                <option value="" disabled selected>
                                    Pilih Satuan
                                </option>

                                <option value="Tablet">Tablet</option>
                                <option value="Kapsul">Kapsul</option>
                                <option value="Botol">Botol</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Strip">Strip</option>
                                <option value="Syrup">Syrup</option>
                                <option value="Ampul">Ampul</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Jumlah Stok Awal
                            </label>

                            <input type="number"
                                   name="stok"
                                   class="form-control"
                                   min="0"
                                   placeholder="0"
                                   required>
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn-modal">
                        Simpan Data
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection