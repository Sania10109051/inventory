<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_peminjaman',
        'id_barang',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}
