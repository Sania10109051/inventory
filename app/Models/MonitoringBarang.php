<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringBarang extends Model
{
    protected $table = 'monitoring_barang';
    protected $primaryKey = 'id_monitoring';
    protected $fillable = [
        'id_barang',
        'id_user',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;

    public function barang()
    {
        return $this->belongsTo(Inventaris::class, 'id_barang');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
