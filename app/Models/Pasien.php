<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasiens';

    protected $fillable = [
        'nama_pasien',
        'nomor_rm',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'usia',
        'alamat',
        'alergi_obat',
        'keterangan',
        'status_asuransi',  // ← ini yang kurang
        'penebusan_obat',
    ];
    
    public function resep()
    {
        return $this->hasMany(Resep::class, 'pasien_id'); 
    }
}