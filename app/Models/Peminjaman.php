<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'id_user',
        'id_barang',
        'tgl_pinjam',
        'tgl_kembali',
        'foto_barang',
        'status',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;

    
}
