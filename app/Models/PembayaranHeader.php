<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranHeader extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_header';

    protected $fillable = [
        'kode_pesanan', 'tanggal_pembayaran', 'id_konsumen', 'total_tagihan', 'total_tagihan_ppn', 'jumlah_pembayaran', 'jumlah_kembalian', 'metode_pembayaran', 'status'
    ];
}
