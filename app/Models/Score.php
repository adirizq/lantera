<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';

    protected $fillable = [
        'lansia_id',
        'pemeriksaan_id',
        'score_malnutrisi',
        'score_penglihatan',
        'score_pendengaran',
        'score_mobilitas',
        'score_kognitif',
        'score_gejala_depresi',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }
}
