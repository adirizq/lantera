<?php

namespace App\Http\Controllers;


use App\Models\Kader;
use App\Models\Lansia;
use App\Models\Pemeriksaan;
use App\Http\Requests\StorePemeriksaanRequest;
use App\Http\Requests\UpdatePemeriksaanRequest;
use Illuminate\Support\Facades\Storage;

class PemeriksaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kader = Kader::where('puskesmas_id', auth()->user()->puskesmas->id)->get();
        $pemeriksaan = Pemeriksaan::whereIn('kader_id', $kader->pluck('id'))->with(['kader', 'lansia'])->get();

        return view('dashboard.puskesmas.pemeriksaan', [
            'page' => 'Data Pemeriksaan',
            'pemeriksaan' => $pemeriksaan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePemeriksaanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePemeriksaanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function show(Pemeriksaan $pemeriksaan)
    {
        return view('dashboard.puskesmas.pemeriksaan_detail', [
            'page' => 'Data Pemeriksaan',
            'pemeriksaan' => $pemeriksaan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pemeriksaan $pemeriksaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePemeriksaanRequest  $request
     * @param  \App\Models\Pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePemeriksaanRequest $request, Pemeriksaan $pemeriksaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemeriksaan $pemeriksaan)
    {
        //
    }


    public function apiIndex()
    {
        return Pemeriksaan::all();
    }

    public function apiShow(Pemeriksaan $pemeriksaan)
    {
        return $pemeriksaan;
    }


    public function apiRegister()
    {
        $defaultRule = ['required', 'string', 'max:255'];

        $data = request()->validate([
            'lansia_id' => ['required', 'integer', 'exists:lansia,id'],
            'kader_id' => ['required', 'integer', 'exists:kader,id'],
            'suhu_tubuh' => $defaultRule,
            'tekanan_darah_sistole' => $defaultRule,
            'tekanan_darah_diastole' => $defaultRule,
            'denyut_nadi' => $defaultRule,
            'kolestrol' => $defaultRule,
            'glukosa' => $defaultRule,
            'kondisi' => $defaultRule,
            'asam_urat' => $defaultRule,
            'respiratory_rate' => $defaultRule,
            'spo2' => $defaultRule,
            'berat_badan' => $defaultRule,
            'lingkar_perut' => $defaultRule,
            'swab' => $defaultRule,
            'sub_1_pola_makan' => $defaultRule,
            'sub_1_pola_bab' => $defaultRule,
            'sub_1_puasa' => $defaultRule,
            'sub_1_catatan' => $defaultRule,
            'sub_2_pola_minum' => $defaultRule,
            'sub_2_pola_bak' => $defaultRule,
            'sub_2_catatan' => $defaultRule,
            'sub_3_tarik_napas' => $defaultRule,
            'sub_3_buang_napas' => $defaultRule,
            'sub_3_catatan' => $defaultRule,
            'sub_4_tidur' => $defaultRule,
            'sub_4_bangun_tidur' => $defaultRule,
            'sub_4_catatan' => $defaultRule,
            'sub_5_pola_seksual' => $defaultRule,
            'sub_5_catatan' => $defaultRule,
            'sub_6_penglihatan' => $defaultRule,
            'sub_6_catatan' => $defaultRule,
            'sub_7_pendengaran' => $defaultRule,
            'sub_7_catatan' => $defaultRule,
            'sub_8_perasa' => $defaultRule,
            'sub_8_catatan' => $defaultRule,
            'sub_9_penciuman' => $defaultRule,
            'sub_9_catatan' => $defaultRule,
            'sub_10_mobilitas' => $defaultRule,
            'sub_10_catatan' => $defaultRule,
            'sub_11_pendapatan' => $defaultRule,
            'sub_11_catatan' => $defaultRule,
            'sub_12_aktivitas_sosial' => $defaultRule,
            'sub_12_catatan' => $defaultRule,
            'sub_13_ibadah' => $defaultRule,
            'sub_13_catatan' => $defaultRule,
            'sub_14_dukungan_keluarga' => $defaultRule,
            'sub_14_catatan' => $defaultRule,
            'sub_15_tinggal_bersama' => $defaultRule,
            'sub_15_catatan' => $defaultRule,
            'keluhan_utama' => $defaultRule,
            'tindakan_perawatan' => $defaultRule,
            'tindakan_kedokteran' => $defaultRule,
            'foto' => 'image|file',
            'mulai_pemeriksaan' => ['required', 'date'],
            'selesai_pemeriksaan' => ['required', 'date'],
            'longitute' => $defaultRule,
            'latitude' => $defaultRule,
        ]);

        if (request()->file('foto')) {
            $data['foto'] = request()->file('foto')->storeAs('foto-pemeriksaan', 'l' . $data['lansia_id'] . '_k' . $data['kader_id'] . '_' . date('Y-m-d H:i:s') . '.' . request()->file('foto')->extension());
        }

        $pemeriksaan = Pemeriksaan::create($data);

        return $pemeriksaan;
    }

    public function apiByLansia(Lansia $lansia)
    {
        return Pemeriksaan::where('lansia_id', $lansia->id)->get();
    }

    public function apiByKader(Kader $kader)
    {
        return Pemeriksaan::where('kader_id', $kader->id)->get();
    }

    public function apiDestroy(Pemeriksaan $pemeriksaan)
    {
        if ($pemeriksaan->foto) {
            Storage::delete($pemeriksaan->foto);
        }


        if ($pemeriksaan->delete()) {
            return [
                'status' => 'Berhasil menghapus data pemeriksaan'
            ];
        } else {
            return [
                'status' => 'Penghapusan data pemeriksaan gagal'
            ];
        }
    }
}
