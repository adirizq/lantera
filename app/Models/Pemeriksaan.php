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
        'suhu_tubuh',
        'tekanan_darah_sistole',
        'tekanan_darah_diastole',
        'denyut_nadi',
        'kolestrol',
        'glukosa',
        'kondisi',
        'asam_urat',
        'respiratory_rate',
        'spo2',
        'berat_badan',
        'lingkar_perut',
        'swab',
        'sub_1_pola_makan',
        'sub_1_pola_bab',
        'sub_1_puasa',
        'sub_1_catatan',
        'sub_2_pola_minum',
        'sub_2_pola_bak',
        'sub_2_catatan',
        'sub_3_tarik_napas',
        'sub_3_buang_napas',
        'sub_3_catatan',
        'sub_4_tidur',
        'sub_4_bangun_tidur',
        'sub_4_catatan',
        'sub_5_pola_seksual',
        'sub_5_catatan',
        'sub_6_penglihatan',
        'sub_6_catatan',
        'sub_7_pendengaran',
        'sub_7_catatan',
        'sub_8_perasa',
        'sub_8_catatan',
        'sub_9_penciuman',
        'sub_9_catatan',
        'sub_10_mobilitas',
        'sub_10_catatan',
        'sub_11_pendapatan',
        'sub_11_catatan',
        'sub_12_aktivitas_sosial',
        'sub_12_catatan',
        'sub_13_ibadah',
        'sub_13_catatan',
        'sub_14_dukungan_keluarga',
        'sub_14_catatan',
        'sub_15_tinggal_bersama',
        'sub_15_catatan',
        'keluhan_utama',
        'tindakan_perawatan',
        'tindakan_kedokteran',
        'foto',
        'mulai_pemeriksaan',
        'selesai_pemeriksaan',
        'longitute',
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
}
