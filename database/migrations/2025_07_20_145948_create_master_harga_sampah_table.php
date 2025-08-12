<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_harga_sampah', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_master_jenis_sampah')
                ->constrained('master_jenis_sampah')
                ->onDelete('cascade');

            $table->foreignId('id_master_satuan')
                ->nullable()
                ->constrained('master_satuan')
                ->nullOnDelete();

            $table->float('harga_sampah', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_harga_sampah');
    }
};