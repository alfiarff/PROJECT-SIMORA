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
    Schema::table('pasiens', function (Blueprint $table) {
        $table->boolean('penebusan_obat')->default(0)->after('status_asuransi');
    });
    }

public function down()
    {
    Schema::table('pasiens', function (Blueprint $table) {
        $table->dropColumn('penebusan_obat');
    });
    }
};
