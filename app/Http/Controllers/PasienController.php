<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    // tampil data pasien
    public function index(Request $request)
    {
        $search = $request->search;

        $pasien = Pasien::when($search, function ($query, $search) {
            return $query->where('nama_pasien', 'like', "%{$search}%")
                         ->orWhere('nomor_rm', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('pasien.index', compact('pasien', 'search'));
    }

    // form tambah pasien
    public function create()
    {
        $lastPasien = Pasien::orderBy('id', 'desc')->first();

        if ($lastPasien && preg_match('/RM-(\d+)/', $lastPasien->nomor_rm, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        $nomorRmBaru = 'RM-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return view('pasien.create', compact('nomorRmBaru'));
    }

    // simpan pasien baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien'     => 'required|string|max:255',
            'nomor_rm'        => 'required|unique:pasiens,nomor_rm',
            'jenis_kelamin'   => 'required',
            'tempat_lahir'    => 'required',
            'tanggal_lahir'   => 'required|date',
            'usia'            => 'required|integer',
            'alamat'          => 'required',
            'alergi_obat'     => 'required',
            'status_asuransi' => 'required|in:BPJS,Umum',  // ← ditambahkan
        ]);

        Pasien::create([
            'nama_pasien'     => $request->nama_pasien,
            'nomor_rm'        => $request->nomor_rm,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'usia'            => $request->usia,
            'alamat'          => $request->alamat,
            'alergi_obat'     => $request->alergi_obat,
            'keterangan'      => $request->keterangan,
            'status_asuransi' => $request->status_asuransi,  // ← ditambahkan
        ]);

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    // form edit pasien
    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.edit', compact('pasien'));
    }

    // update data pasien
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $request->validate([
            'nama_pasien'     => 'required|string|max:255',
            'nomor_rm'        => 'required|unique:pasiens,nomor_rm,'.$id,
            'jenis_kelamin'   => 'required',
            'tempat_lahir'    => 'required',
            'tanggal_lahir'   => 'required|date',
            'usia'            => 'required|integer',
            'alamat'          => 'required',
            'alergi_obat'     => 'required',
            'status_asuransi' => 'required|in:BPJS,Umum',  // ← ditambahkan
        ]);

        $pasien->update([
            'nama_pasien'     => $request->nama_pasien,
            'nomor_rm'        => $request->nomor_rm,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'usia'            => $request->usia,
            'alamat'          => $request->alamat,
            'alergi_obat'     => $request->alergi_obat,
            'keterangan'      => $request->keterangan,
            'status_asuransi' => $request->status_asuransi,  // ← ditambahkan
        ]);

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diupdate.');
    }

    // hapus pasien
    public function destroy($id)
    {
        $pasien = \App\Models\Pasien::findOrFail($id);
        \App\Models\Resep::where('pasien_id', $pasien->id)->delete();
        $pasien->delete();

        return redirect()->back()->with('success', 'Data Pasien beserta riwayat Resepnya berhasil dihapus!');
    }

    public function detail($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pmik.detail_pasien', compact('pasien'));
    }
}