<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSatuan extends Model
{
    use HasFactory;

    protected $table = 'master_satuan';
    protected $fillable = [
        'satuan'
    ];
}
