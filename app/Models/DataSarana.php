<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSarana extends Model
{
    protected $table = 'data_sarana';
    protected $primaryKey = 'id_sarana';
    public $timestamps = false;

    protected $fillable = [
        'nama_sarana',
        'jenis_sarana',
        'jumlah',
        'id_ruangan'
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }
}
