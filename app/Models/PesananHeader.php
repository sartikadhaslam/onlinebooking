<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananHeader extends Model
{
    use HasFactory;

    protected $table = 'pesanan_header';

    protected $fillable = [
        'kode_pesanan', 'tanggal_pesanan', 'tipe_pesanan', 'id_reservasi', 'nama_penerima', 'no_hp_penerima', 'alamat_penerima', 'catatan', 'total'
    ];
}