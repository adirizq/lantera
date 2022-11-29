<?php

namespace App\Http\Controllers;

use App\Models\Puskesmas;
use App\Http\Requests\StorepuskesmasRequest;
use App\Http\Requests\UpdatepuskesmasRequest;
use Laravolt\Indonesia\IndonesiaService;

class PuskesmasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puskesmas = Puskesmas::all();

        return view('dashboard.admin.puskesmas', [
            'page' => 'Puskesmas',
            'puskesmas' => $puskesmas,
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
     * @param  \App\Http\Requests\StorepuskesmasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepuskesmasRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Puskesmas  $puskesmas
     * @return \Illuminate\Http\Response
     */
    public function show(Puskesmas $puskesmas)
    {
        $puskesmas->provinsi = \Indonesia::findProvince($puskesmas->id_provinsi, $with = null)->name;
        $puskesmas->kota = \Indonesia::findCity($puskesmas->id_kota, $with = null)->name;
        $puskesmas->kecamatan = \Indonesia::findDistrict($puskesmas->id_kecamatan, $with = null)->name;
        $puskesmas->kelurahan = \Indonesia::findVillage($puskesmas->id_kelurahan, $with = null)->name;

        return response()->json($puskesmas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Puskesmas  $puskesmas
     * @return \Illuminate\Http\Response
     */
    public function edit(Puskesmas $puskesmas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepuskesmasRequest  $request
     * @param  \App\Models\Puskesmas  $puskesmas
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepuskesmasRequest $request, puskesmas $puskesmas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Puskesmas  $puskesmas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Puskesmas $puskesmas)
    {
        //
    }


    public function validating(Puskesmas $puskesmas)
    {
        $puskesmas->verified_at = now();
        $puskesmas->save();

        return back()->with('success', 'Berhasil memvalidasi akun ' . $puskesmas->nama_puskesmas);
    }

    public function removeValidation(Puskesmas $puskesmas)
    {
        $puskesmas->verified_at = null;
        $puskesmas->save();

        return back()->with('success', 'Berhasil menghapus validasi akun ' . $puskesmas->nama_puskesmas);
    }


    public function apiIndex()
    {
        return Puskesmas::all();
    }


    public function apiShow(Puskesmas $puskesmas)
    {
        return $puskesmas;
    }
}
