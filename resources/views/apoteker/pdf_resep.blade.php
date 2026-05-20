<!DOCTYPE html>
<html>
<head>
    <title>Salinan Resep - SI-MORA</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .data-table th { background-color: #75162d; color: white; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0;">KLINIK SI-MORA</h2>
        <p style="margin:0;">Jl. Raya Jember No. 123, Jember, Jawa Timur</p>
    </div>

    <h3 style="text-align:center;">SALINAN RESEP</h3>

    <table class="info-table">
        <tr>
            <td width="15%">Nama Pasien</td>
            <td>: {{ $resep->pasien->nama_pasien ?? '-' }}</td>
            <td width="15%">Tanggal</td>
            <td>: {{ \Carbon\Carbon::parse($resep->created_at)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Dokter</td>
            <td>: {{ $resep->nama_dokter }}</td>
            <td>Status</td>
            <td>: {{ $resep->status }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Dosis / Aturan Pakai</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php
                $obats = explode(',', $resep->nama_obat);
                $dosis = explode(',', $resep->dosis_obat);
                $jumlahs = explode(',', $resep->jumlah);
            @endphp
            @foreach($obats as $i => $obat)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ trim($obat) }}</td>
                <td>{{ trim($dosis[$i] ?? '-') }}</td>
                <td>{{ trim($jumlahs[$i] ?? '0') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Jember, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><strong>( {{ Auth::user()->name }} )</strong><br>Apoteker</p>
    </div>
</body>
</html>