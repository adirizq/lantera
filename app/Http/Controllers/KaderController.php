<?php

namespace App\Http\Controllers;

use App\Models\Kader;
use App\Http\Requests\StoreKaderRequest;
use App\Http\Requests\UpdateKaderRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kader = Kader::where('puskesmas_id', auth()->user()->puskesmas->id)->get();

        return view('dashboard.puskesmas.kader', [
            'page' => 'Kader',
            'kader' => $kader,
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
     * @param  \App\Http\Requests\StoreKaderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKaderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kader  $kader
     * @return \Illuminate\Http\Response
     */
    public function show(Kader $kader)
    {
        $kader->puskesmas = $kader->puskesmas->nama_puskesmas;
        $kader->provinsi = \Indonesia::findProvince($kader->id_provinsi, $with = null)->name;
        $kader->kota = \Indonesia::findCity($kader->id_kota, $with = null)->name;
        $kader->kecamatan = \Indonesia::findDistrict($kader->id_kecamatan, $with = null)->name;
        $kader->kelurahan = \Indonesia::findVillage($kader->id_kelurahan, $with = null)->name;

        return response()->json($kader);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kader  $kader
     * @return \Illuminate\Http\Response
     */
    public function edit(Kader $kader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKaderRequest  $request
     * @param  \App\Models\Kader  $kader
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKaderRequest $request, Kader $kader)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kader  $kader
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kader $kader)
    {
        //
    }


    public function validating(Kader $kader)
    {
        $kader->verified_at = now();
        $kader->save();

        return back()->with('success', 'Berhasil memvalidasi akun Kader ' . $kader->nama);
    }

    public function removeValidation(Kader $kader)
    {
        $kader->verified_at = null;
        $kader->save();

        return back()->with('success', 'Berhasil menghapus validasi akun Kader ' . $kader->nama);
    }


    public function apiIndex()
    {
        return Kader::all();
    }

    public function apiShow(Kader $kader)
    {
        return $kader;
    }

    public function apiRegister()
    {

        request()->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'puskesmas_id' => ['required', 'integer', 'exists:puskesmas,id'],
            'nama' => ['required', 'string', 'max:255'],
            'tgl_lahir' => ['required'],
            'alamat_domisili' => ['required'],
            'id_provinsi' => ['required'],
            'id_kota' => ['required'],
            'id_kecamatan' => ['required'],
            'id_kelurahan' => ['required'],
            'rt' => ['required'],
            'rw' => ['required'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'username' => request('username'),
            'password' => Hash::make(request('password')),
            'role' => 2,
        ]);

        if ($user) {
            $kader = Kader::create([
                'user_id' => $user->id,
                'puskesmas_id' => request('puskesmas_id'),
                'nama' => request('nama'),
                'tgl_lahir' => request('tgl_lahir'),
                'alamat_domisili' => request('alamat_domisili'),
                'id_provinsi' => request('id_provinsi'),
                'id_kota' => request('id_kota'),
                'id_kecamatan' => request('id_kecamatan'),
                'id_kelurahan' => request('id_kelurahan'),
                'rt' => request('rt'),
                'rw' => request('rw'),
                'pekerjaan' => request('pekerjaan'),
            ]);

            if ($kader) {
                return $kader;
            } else {
                $user->delete();
                return response('Gagal buat akun. Code [1]', 400);
            }
        } else {
            $user->delete();
            return response('Gagal buat akun. Code [1]', 400);
        }
    }
}
