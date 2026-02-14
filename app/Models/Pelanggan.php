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
}
