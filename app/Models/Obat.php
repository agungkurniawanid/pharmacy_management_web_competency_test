<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    /** @use HasFactory<\Database\Factories\ObatFactory> */
    use HasFactory;
    protected $primaryKey = 'kode_obat';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'jenis',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'kode_supplier',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier');
    }

    public function pembelianDetails()
{
    return $this->hasMany(
        PembelianDetail::class,
        'kode_obat',
        'kode_obat'
    );
}

}
