<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operasional extends Model
{
    use HasFactory;

    protected $table = 'operasional'; // nama tabel
    protected $primaryKey = 'id';

    // kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'tanggal',
        'jenis_operasional',
        'jumlah',
        'keterangan',
    ];

    public $timestamps = false; // kalau tabelmu tidak ada created_at & updated_at
}
