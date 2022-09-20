<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    use HasFactory;

    protected $table = 'data_konsumen';

    protected $fillable = [
        'nama_lengkap', 'email', 'nomor_telepon', 'no_ktp', 'alamat_domisili',
    ];
}
