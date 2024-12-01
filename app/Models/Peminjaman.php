<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventaris;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'id_user',
        'tgl_pinjam',
        'tgl_tenggat',
        'tgl_kembali',
        'keterangan',
        'status',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
    

    
}
