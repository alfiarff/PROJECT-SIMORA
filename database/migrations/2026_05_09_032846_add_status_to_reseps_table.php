<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('reseps', function (Blueprint $table) {
            // Menambahkan kolom status dengan nilai default 'Pending'
            // after() digunakan agar posisinya rapi, bisa Anda sesuaikan dengan nama kolom terakhir di tabel Anda
            $table->string('status')->default('Pending'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reseps', function (Blueprint $table) {
            // Menghapus kolom jika kita melakukan rollback
            $table->dropColumn('status');
        });
    }
};
