<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Obat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ApotekerController extends Controller
{
    public function index(Request $request)
    {
        $resepMasuk    = Resep::whereIn('status', ['Pending', 'Diproses', 'Stok Habis'])->count();
        $resepDiproses = Resep::where('status', 'Diproses')->count();
        $resepSelesai  = Resep::where('status', 'Selesai')->count();

        $search = $request->input('search');

        $reseps = Resep::with('pasien')
            ->when($search, function($query) use ($search) {
                $query->where('nama_obat', 'LIKE', "%{$search}%")
                      ->orWhereHas('pasien', function($q) use ($search) {
                          $q->where('nama_pasien', 'LIKE', "%{$search}%");
                      });
            })
            ->when(!$search, function($query) {
                $query->whereDate('created_at', Carbon::today());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $notifBaru = \App\Models\Notifikasi::where('is_read', 0)->count();
        $notifList = \App\Models\Notifikasi::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard-apoteker', compact(
            'resepMasuk',
            'resepDiproses',
            'resepSelesai',
            'reseps',
            'notifBaru',
            'notifList'
        ));
    }

    public function dataResep(Request $request)
    {
        $search = $request->input('search');

        $data = Resep::with('pasien')
            ->when($search, function($query) use ($search) {
                $query->whereHas('pasien', function($q) use ($search) {
                    $q->where('nama_pasien', 'LIKE', "%{$search}%");
                })->orWhere('nama_obat', 'LIKE', "%{$search}%")
                  ->orWhere('diagnosa', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $obats = Obat::all()->keyBy('nama_obat');

        return view('apoteker.resep', compact('data', 'obats'));
    }

    // ✅ Update status TANPA potong stok
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);
        $resep = Resep::findOrFail($id);

        $resep->update(['status' => $request->status]);

        if ($request->status == 'Selesai') {
            \App\Models\Notifikasi::create([
                'judul'     => 'Resep RSP-' . str_pad($resep->id, 4, '0', STR_PAD_LEFT) . ' berhasil disiapkan',
                'deskripsi' => 'Resep telah selesai disiapkan oleh apoteker',
                'tipe'      => 'success'
            ]);
        }

        return redirect()->back()->with('success', 'Status resep berhasil diperbarui menjadi ' . $request->status . '!');
    }

    // ✅ Penebusan obat = potong stok, uncentang = kembalikan stok
    public function updatePenebusan(Request $request, $id)
{
    $resep = Resep::findOrFail($id);
    $dicentang = $request->has('penebusan_obat');

    // ✅ Hanya update status penebusan, TANPA potong stok
    $resep->penebusan_obat = $dicentang ? 1 : 0;
    $resep->save();

    return redirect()->back()->with('success', 'Status penebusan obat berhasil diperbarui.');
}

    public function stokObat()
    {
        $obats = Obat::orderBy('nama_obat', 'asc')->get();
        return view('apoteker.stok_obat', compact('obats'));
    }

    public function cetakPDF($id)
    {
        $resep = Resep::with('pasien')->findOrFail($id);

        \App\Models\Notifikasi::create([
            'judul'     => 'Resep RSP-' . str_pad($resep->id, 4, '0', STR_PAD_LEFT) . ' telah dicetak',
            'deskripsi' => 'Resep berhasil dicetak pada ' . Carbon::now()->isoFormat('D MMMM Y HH.mm'),
            'tipe'      => 'warning'
        ]);

        $pdf = Pdf::loadView('apoteker.pdf_resep', compact('resep'));
        return $pdf->stream('Resep_' . ($resep->pasien->nama_pasien ?? 'Pasien') . '.pdf');
    }

    public function detailResep($id)
    {
        $resep = Resep::with('pasien')->findOrFail($id);
        return view('apoteker.detail_resep', compact('resep'));
    }

    public function storeObat(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan'    => 'required|string',
            'stok'      => 'required|integer|min:0',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'stok.required'      => 'Jumlah stok awal wajib diisi.',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'satuan'    => $request->satuan,
            'stok'      => $request->stok,
        ]);

        return redirect()->back()->with('success', 'Obat baru berhasil ditambahkan ke daftar stok!');
    }

    public function updateObat(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|numeric|min:0',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->stok = $request->stok;
        $obat->save();

        return redirect()->back()->with('success', 'Stok obat berhasil diperbarui!');
    }

    public function notifikasi()
    {
        \App\Models\Notifikasi::where('is_read', 0)->update(['is_read' => 1]);
        $notifikasis = \App\Models\Notifikasi::orderBy('created_at', 'desc')->get();
        return view('apoteker.notifikasi_apoteker', compact('notifikasis'));
    }

    public function updateObatDipilih(Request $request, $id)
{
    $resep = Resep::findOrFail($id);
    $obatDipilihBaru = array_map('strval', $request->input('obat_dipilih', []));
    $obatDipilihLama = $resep->obat_dipilih ? array_map('strval', json_decode($resep->obat_dipilih, true)) : [];

    $obat_array   = explode(',', $resep->nama_obat);
    $jumlah_array = explode(',', $resep->jumlah);

    foreach ($obat_array as $index => $nama_obat) {
        $nama_obat_bersih = trim($nama_obat);
        $jumlah_obat      = (int) trim($jumlah_array[$index] ?? 0);
        $obat_db          = Obat::where('nama_obat', $nama_obat_bersih)->first();

        if (!$obat_db) continue;

        $dipilihSekarang = in_array((string)$index, $obatDipilihBaru);
        $dipilihSebelum  = in_array((string)$index, $obatDipilihLama);

        // ✅ Baru dicentang → potong stok
        if ($dipilihSekarang && !$dipilihSebelum) {
            if ($obat_db->stok >= $jumlah_obat) {
                $obat_db->stok -= $jumlah_obat;
                $obat_db->save();

                \App\Models\Notifikasi::create([
                    'judul'     => 'Stok ' . $nama_obat_bersih . ' dipotong',
                    'deskripsi' => 'Stok berkurang ' . $jumlah_obat . ' pcs dari resep RSP-' . str_pad($resep->id, 4, '0', STR_PAD_LEFT),
                    'tipe'      => 'success'
                ]);
            } else {
                return redirect()->back()->with('error', "Stok '{$nama_obat_bersih}' tidak mencukupi. Sisa: {$obat_db->stok}.");
            }
        }

        // ✅ Di-uncheck → kembalikan stok
        if (!$dipilihSekarang && $dipilihSebelum) {
            $obat_db->stok += $jumlah_obat;
            $obat_db->save();

            \App\Models\Notifikasi::create([
                'judul'     => 'Stok ' . $nama_obat_bersih . ' dikembalikan',
                'deskripsi' => 'Stok bertambah ' . $jumlah_obat . ' pcs dari pembatalan RSP-' . str_pad($resep->id, 4, '0', STR_PAD_LEFT),
                'tipe'      => 'warning'
            ]);
        }
    }

    $resep->obat_dipilih = json_encode(array_values($obatDipilihBaru));
    $resep->save();

    return redirect()->back()->with('success', 'Pilihan obat berhasil disimpan.');
}
}