<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan';

    protected $fillable = [
        'lansia_id',
        'kader_id',
        'json_data_phce',
        'json_data_subjektif',
        'json_data_keluhan',
        'foto',
        'mulai_pemeriksaan',
        'selesai_pemeriksaan',
        'longitude',
        'latitude',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }

    public function kader()
    {
        return $this->belongsTo(Kader::class);
    }

    public function score()
    {
        return $this->hasOne(Score::class);
    }
}
