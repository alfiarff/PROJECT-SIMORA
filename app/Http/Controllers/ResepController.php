<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Pasien;
use App\Models\Notifikasi; // Import model notifikasi di sini

class ResepController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = Resep::with('pasien')
            ->when($search, function ($query, $search) {
                return $query->whereHas('pasien', function ($q) use ($search) {
                    $q->where('nama_pasien', 'like', "%{$search}%")
                      ->orWhere('nomor_rm', 'like', "%{$search}%");
                })
                ->orWhere('diagnosa', 'like', "%{$search}%")
                ->orWhere('nama_obat', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('resep.index', compact('data'));
    }

    public function create(Request $request)
{
    $pasiens = Pasien::all();
    $pasien_id_terpilih = $request->pasien_id ?? null;
    $pasienAsuransi = $pasiens->pluck('status_asuransi', 'id');
    return view('resep.create', compact('pasiens', 'pasien_id_terpilih', 'pasienAsuransi'));
}

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id'     => 'required|exists:pasiens,id',
            'nama_dokter'   => 'required|string',
            'sip_dokter'    => 'required|string',
            'tanggal_resep' => 'required|date',
            'diagnosa'      => 'required|string|max:255', // Sesuaikan max length db
            'nama_obat'     => 'required|array',
            'nama_obat.*'   => 'required|string',
            'dosis_obat'    => 'required|array',
            'dosis_obat.*'  => 'required|string',
            'jumlah'        => 'required|array', 
            'jumlah.*'      => 'required|string', 
            'keterangan'    => 'nullable|string',
        ]);

        // Simpan ke database
        $resep = Resep::create([
            'pasien_id'     => $request->pasien_id,
            'diagnosa'      => $request->diagnosa, 
            'nama_dokter'   => $request->nama_dokter,
            'sip_dokter'    => $request->sip_dokter,
            'tanggal_resep' => $request->tanggal_resep,
            'nama_obat'     => implode(', ', $request->nama_obat),
            'dosis_obat'    => implode(', ', $request->dosis_obat),
            'jumlah'        => implode(', ', $request->jumlah), 
            'keterangan'    => $request->keterangan,
            'status'        => 'Pending', 
        ]);
        
        if ($resep) {
            $pasien = Pasien::find($request->pasien_id);
            Notifikasi::create([
                'judul'     => 'Resep Baru Masuk!',
                'deskripsi' => 'Resep untuk pasien ' . ($pasien->nama_pasien ?? 'Umum') . ' telah dikirim oleh ' . $request->nama_dokter,
                'tipe'      => 'info' 
            ]);
        }
        
        return redirect()->route('resep.index')->with('success', 'Resep berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $resep = Resep::findOrFail($id);
        $pasiens = Pasien::all();
        return view('resep.edit', compact('resep', 'pasiens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien_id'     => 'required|exists:pasiens,id',
            'nama_dokter'   => 'required|string',
            'sip_dokter'    => 'required|string',
            'tanggal_resep' => 'required|date',
            'diagnosa'      => 'required|string|max:255',
            'nama_obat'     => 'required', 
            'dosis_obat'    => 'required',
            'jumlah'        => 'required', 
            'keterangan'    => 'nullable|string',
        ]);

        $resep = Resep::findOrFail($id);

        $resep->update([
            'pasien_id'     => $request->pasien_id,
            'diagnosa'      => $request->diagnosa, 
            'nama_dokter'   => $request->nama_dokter,
            'sip_dokter'    => $request->sip_dokter,
            'tanggal_resep' => $request->tanggal_resep,
            'nama_obat'     => is_array($request->nama_obat) ? implode(', ', $request->nama_obat) : $request->nama_obat,
            'dosis_obat'    => is_array($request->dosis_obat) ? implode(', ', $request->dosis_obat) : $request->dosis_obat,
            'jumlah'        => is_array($request->jumlah) ? implode(', ', $request->jumlah) : $request->jumlah, 
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('resep.index')->with('success', 'Data resep berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $resep = Resep::findOrFail($id);
        $resep->delete();

        return redirect()->route('resep.index')->with('success', 'Data resep berhasil dihapus!');
    }
}