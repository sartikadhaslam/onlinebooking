<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMenu extends Model
{
    use HasFactory;

    protected $table = 'data_menu';

    protected $fillable = [
        'nama_menu', 'deskripsi', 'harga', 'foto'
    ];
}
