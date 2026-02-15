<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'kode_pelanggan';

    protected $fillable = [
        'kode_pelanggan',
        'nama_pelanggan',
        'alamat',
        'telpon',
    ];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'kode_pelanggan', 'kode_pelanggan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
