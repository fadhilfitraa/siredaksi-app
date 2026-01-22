<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
{
    Schema::table('siswas', function (Blueprint $table) {
        // Tambah kolom baru setelah tingkatan, boleh kosong (nullable)
        $table->string('asal_sekolah')->nullable()->after('tingkatan');
    });
}

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            //
        });
    }
};
