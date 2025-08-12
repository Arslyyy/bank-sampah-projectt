<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_nasabah', function (Blueprint $table) {
        $table->id();
        $table->datetime("tanggal_transaksi");

        // Relasi ke nasabah
        $table->foreignId('master_nasabah_id')
            ->constrained('master_nasabah')
            ->onDelete('cascade');

        // Relasi ke jenis sampah
        $table->foreignId('master_jenis_sampah_id')
            ->constrained('master_jenis_sampah')
            ->onDelete('cascade');

        // Relasi ke satuan
        $table->foreignId('master_satuan_id')
            ->constrained('master_satuan')
            ->onDelete('restrict');

        $table->float('jumlah');

        // Tambahan baru
        $table->string('uraian')->nullable(); // keterangan transaksi
        $table->enum('jenis', ['pemasukan', 'pengeluaran'])->default('pengeluaran');

        $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_nasabah');
    }
};