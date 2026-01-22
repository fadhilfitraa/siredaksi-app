<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('siswas', function (Blueprint $table) {
        // Menambahkan kolom no_hp setelah kolom asal_sekolah
        $table->string('no_hp', 20)->nullable()->after('asal_sekolah');
    });
}

public function down()
{
    Schema::table('siswas', function (Blueprint $table) {
        $table->dropColumn('no_hp');
    });
}
};
