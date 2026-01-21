<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('pembayarans', function (Blueprint $table) {
        
        $table->string('bulan_bayar')->nullable()->after('tanggal_bayar');
        $table->string('metode_pembayaran')->default('Tunai')->after('jumlah_bayar');
        $table->text('keterangan')->nullable()->after('metode_pembayaran');
    });
}

public function down(): void
{
    Schema::table('pembayarans', function (Blueprint $table) {
        $table->dropColumn(['bulan_bayar', 'metode_pembayaran', 'keterangan']);
    });
}
};
