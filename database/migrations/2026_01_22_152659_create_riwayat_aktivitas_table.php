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
    Schema::create('riwayat_aktivitas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Siapa Adminnya
        $table->string('aksi'); // Tambah, Ubah, Hapus
        $table->string('tipe_objek'); // Siswa, Pembayaran
        $table->text('deskripsi'); // Detail aktivitas (misal: "Menerima bayaran dari Budi")
        $table->timestamps(); // Kapan kejadiannya
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_aktivitas');
    }
};
