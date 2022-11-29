<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    use HasFactory;

    protected $fillable = [
        'longitute',
        'latitude',
        'lansia_id',
        'kader_id',
        'status',
    ];


    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }

    public function kader()
    {
        return $this->belongsTo(Kader::class);
    }
}
