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
        'user_id',         // PENTING: Untuk relasi jika buat akun
        'nama_pelanggan',
        'alamat',
        'kota',            // PENTING: Tambahkan ini agar bisa di-save!
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
