<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // kalau tabelnya bernama 'master_nasabah'
            $table->foreignId('master_nasabah_id')
                  ->nullable()
                  ->constrained('master_nasabah')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['master_nasabah_id']);
            $table->dropColumn('master_nasabah_id');
        });
    }
};
