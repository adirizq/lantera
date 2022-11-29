<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePosyanduRequest;
use App\Models\Puskesmas;

class PosyanduController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posyandu = Posyandu::where('puskesmas_id', auth()->user()->puskesmas->id)->get();

        return view('dashboard.puskesmas.posyandu', [
            'page' => 'Posyandu',
            'posyandu' => $posyandu,
            'provinsi' => \Indonesia::allProvinces(),
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'id_provinsi' => ['required', 'integer'],
            'id_kota' => ['required', 'integer'],
            'id_kecamatan' => ['required', 'integer'],
            'id_kelurahan' => ['required', 'integer'],
            'rt' => ['required', 'numeric', 'max:255'],
            'rw' => ['required', 'numeric', 'max:255'],
            'alamat' => ['required', 'string'],
        ]);

        $validatedData['puskesmas_id'] = auth()->user()->puskesmas->id;

        Posyandu::create($validatedData);

        return back()->with('success', 'Berhasil menambah data posyandu baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posyandu  $posyandu
     * @return \Illuminate\Http\Response
     */
    public function show(Posyandu $posyandu)
    {
        $posyandu->provinsi = \Indonesia::findProvince($posyandu->id_provinsi, $with = null)->name;
        $posyandu->kota = \Indonesia::findCity($posyandu->id_kota, $with = null)->name;
        $posyandu->kecamatan = \Indonesia::findDistrict($posyandu->id_kecamatan, $with = null)->name;
        $posyandu->kelurahan = \Indonesia::findVillage($posyandu->id_kelurahan, $with = null)->name;

        return response()->json($posyandu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posyandu  $posyandu
     * @return \Illuminate\Http\Response
     */
    public function edit(Posyandu $posyandu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePosyanduRequest  $request
     * @param  \App\Models\Posyandu  $posyandu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePosyanduRequest $request, Posyandu $posyandu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posyandu  $posyandu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posyandu $posyandu)
    {
        $name = $posyandu->nama;

        $posyandu->delete();

        return back()->with('success', 'Berhasil menghapus Posyandu ' . $name);
    }


    public function apiIndex(Puskesmas $puskesmas)
    {
        return Posyandu::where('puskesmas_id', $puskesmas->id)->get();
    }


    public function apiShow(Posyandu $posyandu)
    {
        return $posyandu;
    }
}
