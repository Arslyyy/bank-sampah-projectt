<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // tambahkan kolom nasabah_id
            $table->unsignedBigInteger('nasabah_id')->nullable()->after('role');

            // buat foreign key ke tabel master_nasabah
            $table->foreign('nasabah_id')
                  ->references('id')
                  ->on('master_nasabah')
                  ->onDelete('cascade'); // jika nasabah dihapus, user juga otomatis terhapus
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // hapus foreign key dulu
            $table->dropForeign(['nasabah_id']);
            $table->dropColumn('nasabah_id');
        });
    }
};
