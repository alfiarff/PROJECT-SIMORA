<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pasiens', function (Blueprint $table) {
        $table->id(); // ID otomatis (Primary Key)
        $table->string('nama_pasien');
        $table->string('nomor_rm')->unique(); // Unique agar nomor RM tidak boleh sama
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->string('tempat_lahir');
        $table->date('tanggal_lahir');
        $table->integer('usia');
        $table->text('alamat');
        $table->string('alergi_obat');
        $table->text('keterangan')->nullable(); // Nullable berarti boleh dikosongkan
        $table->timestamps(); // Membuat kolom created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
