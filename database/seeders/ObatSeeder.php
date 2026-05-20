<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Obat;
class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
    Obat::create(['nama_obat' => 'Amlodipine', 'stok' => 100, 'satuan' => 'Tablet']);
    Obat::create(['nama_obat' => 'Omeprazole', 'stok' => 50, 'satuan' => 'Kapsul']);
    Obat::create(['nama_obat' => 'Metformin', 'stok' => 200, 'satuan' => 'Tablet']);
    Obat::create(['nama_obat' => 'Paratusin', 'stok' => 300, 'satuan' => 'Tablet']);
    }
}
