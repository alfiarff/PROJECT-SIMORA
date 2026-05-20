<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::table('reseps', function (Blueprint $table) {
        // Mengubah integer menjadi string agar bisa menampung hasil implode "10, 5, 4"
        $table->string('jumlah')->change();
     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reseps', function (Blueprint $table) {
        $table->integer('jumlah')->change();
    });
    }
};
