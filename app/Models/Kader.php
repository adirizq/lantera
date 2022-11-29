<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kader extends Model
{
    use HasFactory;

    protected $table = 'kader';

    protected $fillable = [
        'user_id',
        'puskesmas_id',
        'nama',
        'tgl_lahir',
        'alamat_domisili',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
        'id_kelurahan',
        'rt',
        'rw',
        'pekerjaan',
    ];

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function emergencies()
    {
        return $this->hasMany(Emergency::class);
    }
}
