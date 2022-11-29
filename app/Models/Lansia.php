<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lansia extends Model
{
    use HasFactory;

    protected $table = 'lansia';

    protected $fillable = [
        'posyandu_id',
        'no_ktp',
        'no_kk',
        'nama',
        'tgl_lahir',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
        'id_kelurahan',
        'rt',
        'rw',
        'alamat_domisili',
        'alamat_ktp',
        'pekerjaan',
    ];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
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
