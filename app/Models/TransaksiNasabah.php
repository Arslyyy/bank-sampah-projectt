<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiNasabah extends Model
{
    use HasFactory;

    protected $table = 'transaksi_nasabah';

    protected $fillable = [
        'id_transaksi',
        'tanggal_transaksi',
        'master_nasabah_id',
        'master_jenis_sampah_id',
        'master_satuan_id',
        'jumlah_berat',
        'jumlah',
        'jenis',
    ];

    protected $casts = [
    'tanggal_transaksi' => 'date',
    ];

    // Relasi ke nasabah
    public function nasabah()
    {
        return $this->belongsTo(MasterNasabah::class, 'master_nasabah_id');
    }

    // Relasi ke jenis sampah
    public function jenisSampah()
    {
        return $this->belongsTo(MasterJenisSampah::class, 'master_jenis_sampah_id');
    }

    // Relasi ke satuan
    public function satuan()
    {
        return $this->belongsTo(MasterSatuan::class, 'master_satuan_id');
    }

    
}
