<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;

    protected $table = 'posyandu';

    protected $fillable = [
        'puskesmas_id',
        'nama',
        'alamat',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
        'id_kelurahan',
        'rt',
        'rw',
    ];


    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function lansia()
    {
        return $this->hasMany(Lansia::class);
    }
}
