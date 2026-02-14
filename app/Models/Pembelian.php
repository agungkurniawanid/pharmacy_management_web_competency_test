<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    /** @use HasFactory<\Database\Factories\PembelianFactory> */
    use HasFactory;
        protected $primaryKey = 'nota';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nota',
        'tanggal_nota',
        'kode_supplier',
        'diskon',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier');
    }

    public function pembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class, 'nota', 'nota');
    }
}

