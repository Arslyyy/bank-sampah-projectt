<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\MasterHargaSampah;


class MasterJenisSampah extends Model
{
    use HasFactory;

    protected $table = 'master_jenis_sampah';
    protected $fillable = [
        'type_sampah'
    ];

    public function harga(): HasMany
    {
        return $this->hasMany(MasterHargaSampah::class, 'id_master_jenis_sampah');
    }

}
