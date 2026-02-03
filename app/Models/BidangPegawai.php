<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BidangPegawai extends Model
{
    use HasFactory;

    protected $table = 'bidang_pegawai';
    protected $primaryKey = 'id_bidang';
    public $timestamps = false;

    protected $fillable = [
        'bidang',
        'sub_bidang'
    ];

    
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_bidang', 'id_bidang');
    }
}
