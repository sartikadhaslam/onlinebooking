<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';

    protected $fillable = [
        'tanggal_reservasi', 'kode_booking', 'id_konsumen', 'jumlah_tamu', 'untuk_tanggal', 'status'
    ];
}
