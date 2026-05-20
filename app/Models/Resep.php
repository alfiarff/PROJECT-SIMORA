<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    protected $table = 'reseps'; 

    protected $fillable = [
        'pasien_id',
        'diagnosa',
        'nama_dokter',
        'sip_dokter',
        'tanggal_resep',
        'nama_obat',
        'dosis_obat',
        'keterangan',
        'jumlah',
        'status',
        'penebusan_obat', // ✅
        'obat_dipilih',   // ✅
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
}