<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterNasabah extends Model
{
    use HasFactory;

    protected $table = 'master_nasabah';

    protected $fillable = [
        'nama',
        'alamat',
    ];

    /**
     * Relasi ke User (1 nasabah bisa punya banyak user login)
     */
    public function user()
    {
        return $this->hasOne(User::class, 'nasabah_id', 'id');
    }
    public function transaksi()
    {
        return $this->hasMany(TransaksiNasabah::class, 'master_nasabah_id', 'id');
    }
}
