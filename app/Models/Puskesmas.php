<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'verified_at',
        'kode_puskesmas',
        'nama_puskesmas',
        'kepala_puskesmas',
        'nama_admin',
        'alamat',
        'rt',
        'rw',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
        'id_kelurahan',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function kader()
    {
        return $this->hasMany(Kader::class);
    }

    public function posyandu()
    {
        return $this->hasMany(Posyandu::class);
    }
}
