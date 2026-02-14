<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    /** @use HasFactory<\Database\Factories\PenjualanDetailFactory> */
    use HasFactory;

      public $incrementing = false;
    protected $fillable = [
        'nota',
        'kode_obat',
        'jumlah',
    ];
}
