<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'username',
        'password',
    ];

    protected static function booted()
    {
        static::addGlobalScope('superadmin', function ($query) {
            $query->where('role', 'superadmin');
        });
    }
}
