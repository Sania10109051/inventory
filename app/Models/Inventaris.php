<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'barang';
    protected $fillable = [
        'id_barang',
        'nama_barang',
        'jumlah_barang',
        'status_barang',
        'kondisi',
        'qr_code',
        'foto_barang',
        'id_kategori',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    public function barangTersedia()
    {
        return $this->where('status', 1)->get();
    }
}
