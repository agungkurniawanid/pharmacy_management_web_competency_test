<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    /** @use HasFactory<\Database\Factories\PenjualanFactory> */
    use HasFactory;

    protected $primaryKey = 'nota';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nota',
        'tanggal_nota',
        'kode_pelanggan',
        'diskon',
    ];
}
