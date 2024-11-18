<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    protected $table = 'kategori_barang';
    protected $primaryKey = 'id_kategori';
    protected $fillable = [
        'nama_kategori',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;

    public function barang()
    {
        return $this->hasMany(Inventaris::class, 'id_kategori');
    }
}
