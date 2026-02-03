<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';
    public $timestamps = false;

    protected $fillable = [
        'nama_ruangan'
    ];

    // ✅ RELASI KE data_sarana
    public function sarana()
    {
        return $this->hasMany(DataSarana::class, 'id_ruangan');
    }

    public function gambar()
{
    return $this->hasMany(GambarRuangan::class, 'id_ruangan');
}

}
