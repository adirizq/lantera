<?php

namespace App\Http\Controllers;


use App\Models\Kader;
use App\Models\Lansia;
use App\Models\Pemeriksaan;
use App\Http\Requests\StorePemeriksaanRequest;
use App\Http\Requests\UpdatePemeriksaanRequest;
use App\Models\Score;
use App\Models\ViewScores;
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
        $pemeriksaan = Pemeriksaan::whereIn('kader_id', $kader->pluck('id'))->with(['kader', 'lansia'])->get()->sortByDesc('id');

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
        $phce = json_decode($pemeriksaan['json_data_phce'], true);
        $subjektif = json_decode($pemeriksaan['json_data_subjektif'], true);
        $keluhan = json_decode($pemeriksaan['json_data_keluhan'], true);

        $scores = ViewScores::where('pemeriksaan_id', $pemeriksaan->id)->first();

        // dd($subjektif);

        return view('dashboard.puskesmas.pemeriksaan_detail', [
            'page' => 'Data Pemeriksaan',
            'pemeriksaan' => $pemeriksaan,
            'phce' => $phce,
            'subjektif' => $subjektif,
            'keluhan' => $keluhan,
            'scores' => $scores,

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

    public function fix()
    {
        $dictKognitif = [
            "Tepat" => 1,
            "Tidak Tepat" => 2,
            "Tidak Tahu" => 3
        ];

        $pemeriksaan = Pemeriksaan::all()->sortByDesc('id');

        foreach ($pemeriksaan as $p) {
            $score = 0;
            $data = json_decode($p['json_data_subjektif'], true)['Skrinning Kognitif'];

            foreach ($data as $d) {
                $score += $dictKognitif[$d] ?? 0;
            }

            Score::where('pemeriksaan_id', $p->id)->update(['score_kognitif' => $score]);
        }
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
        $integerRule = ['required', 'integer'];
        $stringRule = ['required', 'string'];
        $numericRule = ['required', 'numeric'];

        $dataPemeriksaan = request()->validate([
            'lansia_id' => ['required', 'integer', 'exists:lansia,id'],
            'kader_id' => ['required', 'integer', 'exists:kader,id'],
            'json_data_phce' => $stringRule,
            'json_data_subjektif' => $stringRule,
            'json_data_keluhan' => $stringRule,
            'foto' => 'image|file',
            'mulai_pemeriksaan' => ['required', 'date'],
            'selesai_pemeriksaan' => ['required', 'date'],
            'longitude' => $defaultRule,
            'latitude' => $defaultRule,
        ]);

        $dataScore = request()->validate([
            'lansia_id' => ['required', 'integer', 'exists:lansia,id'],
            'score_malnutrisi' => $integerRule,
            'score_penglihatan' => $integerRule,
            'score_pendengaran' => $integerRule,
            'score_mobilitas' => $integerRule,
            'score_kognitif' => $integerRule,
            'score_gejala_depresi' => $integerRule,
        ]);

        if (request()->file('foto')) {
            $dataPemeriksaan['foto'] = request()->file('foto')->storeAs('foto-pemeriksaan', 'l' . $dataPemeriksaan['lansia_id'] . '_k' . $dataPemeriksaan['kader_id'] . '_' . date('Y-m-d H:i:s') . '.' . request()->file('foto')->extension());
        }

        $pemeriksaan = Pemeriksaan::create($dataPemeriksaan);

        $dataScore['pemeriksaan_id'] = $pemeriksaan->id;

        $score = Score::create($dataScore);

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
        if (Score::where('pemeriksaan_id', $pemeriksaan->id)->delete()) {
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
}
