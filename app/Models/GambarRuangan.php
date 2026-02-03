<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class GambarRuangan extends Model
{
    protected $table = 'gambar_ruangan';

    protected $fillable = [
        'id_ruangan',
        'nama_file'
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }
}
