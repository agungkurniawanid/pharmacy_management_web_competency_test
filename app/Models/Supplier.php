<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;
    protected $primaryKey = 'kode_supplier';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'alamat',
        'kota',
        'telpon',
        'aktif',
        'catatan',
    ];

    public function obats()
    {
        return $this->hasMany(Obat::class, 'kode_supplier', 'kode_supplier');
    }

    public function pembelians() {
        return $this->hasMany(Pembelian::class, 'kode_supplier', 'kode_supplier');
    }
}
