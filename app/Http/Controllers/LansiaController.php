<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Http\Requests\StoreLansiaRequest;
use App\Http\Requests\UpdateLansiaRequest;
use App\Models\Posyandu;
use App\Models\Puskesmas;

class LansiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posyandu = Posyandu::where('puskesmas_id', auth()->user()->puskesmas->id)->get();
        $lansia = Lansia::whereIn('posyandu_id', $posyandu->pluck('id'))->with(['posyandu'])->get()->sortByDesc('id');

        return view('dashboard.puskesmas.lansia', [
            'page' => 'Lansia',
            'lansia' => $lansia,
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
     * @param  \App\Http\Requests\StoreLansiaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLansiaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lansia  $lansia
     * @return \Illuminate\Http\Response
     */
    public function show(Lansia $lansia)
    {

        $lansia->posyandu =  Posyandu::where('id', $lansia->posyandu_id)->first();
        $lansia->provinsi = \Indonesia::findProvince($lansia->id_provinsi, $with = null)->name;
        $lansia->kota = \Indonesia::findCity($lansia->id_kota, $with = null)->name;
        $lansia->kecamatan = \Indonesia::findDistrict($lansia->id_kecamatan, $with = null)->name;
        $lansia->kelurahan = \Indonesia::findVillage($lansia->id_kelurahan, $with = null)->name;

        return response()->json($lansia);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lansia  $lansia
     * @return \Illuminate\Http\Response
     */
    public function edit(Lansia $lansia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLansiaRequest  $request
     * @param  \App\Models\Lansia  $lansia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLansiaRequest $request, Lansia $lansia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lansia  $lansia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lansia $lansia)
    {
        //
    }


    public function apiIndex(Puskesmas $puskesmas)
    {
        $posyandu = Posyandu::where('puskesmas_id', $puskesmas->id)->get();
        $lansia = Lansia::whereIn('posyandu_id', $posyandu->pluck('id'))->with(['posyandu'])->get();

        return $lansia;
    }

    public function apiShow(Lansia $lansia)
    {
        return $lansia;
    }


    public function apiRegister()
    {

        request()->validate([
            'posyandu_id' => ['required', 'exists:posyandu,id'],
            'no_ktp' => ['required', 'string', 'max:255', 'unique:lansia'],
            'no_kk' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
            'tgl_lahir' => ['required', 'date'],
            'id_provinsi' => ['required', 'integer'],
            'id_kota' => ['required', 'integer'],
            'id_kecamatan' => ['required', 'integer'],
            'id_kelurahan' => ['required', 'integer'],
            'rt' => ['required', 'numeric'],
            'rw' => ['required', 'numeric'],
            'alamat_domisili' => ['required', 'string'],
            'alamat_ktp' => ['required', 'string'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
        ]);

        $lansia = Lansia::create([
            'posyandu_id' => request('posyandu_id'),
            'no_ktp' => request('no_ktp'),
            'no_kk' => request('no_kk'),
            'nama' => request('nama'),
            'tgl_lahir' => request('tgl_lahir'),
            'id_provinsi' => request('id_provinsi'),
            'id_kota' => request('id_kota'),
            'id_kecamatan' => request('id_kecamatan'),
            'id_kelurahan' => request('id_kelurahan'),
            'rt' => request('rt'),
            'rw' => request('rw'),
            'alamat_domisili' => request('alamat_domisili'),
            'alamat_ktp' => request('alamat_ktp'),
            'pekerjaan' => request('pekerjaan'),
        ]);

        return $lansia;
    }

    public function apiDestroy(Lansia $lansia)
    {
        return [
            'success' => $lansia->delete()
        ];
    }
}
