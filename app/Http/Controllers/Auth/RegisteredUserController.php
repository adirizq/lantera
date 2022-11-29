<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register', [
            'provinsi' => \Indonesia::allProvinces(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $defaultRule = ['required', 'string', 'max:255'];

        $request->validate([
            'puskesmas_admin_name' => $defaultRule,
            'puskesmas_name' => $defaultRule,
            'puskesmas_head_name' => $defaultRule,
            'puskesmas_code' => $defaultRule,
            'rt' => $defaultRule,
            'rw' => $defaultRule,
            'id_provinsi' => $defaultRule,
            'id_kota' => $defaultRule,
            'id_kecamatan' => $defaultRule,
            'id_kelurahan' => $defaultRule,
            'address' => ['required', 'string'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 1,
        ]);

        if ($user) {
            $puskesmas = Puskesmas::create([
                'user_id' => $user->id,
                'kode_puskesmas' => $request->puskesmas_code,
                'nama_puskesmas' => $request->puskesmas_name,
                'kepala_puskesmas' => $request->puskesmas_head_name,
                'nama_admin' => $request->puskesmas_admin_name,
                'alamat' => $request->address,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'id_provinsi' => $request->id_provinsi,
                'id_kota' => $request->id_kota,
                'id_kecamatan' => $request->id_kecamatan,
                'id_kelurahan' => $request->id_kelurahan,
            ]);

            if ($puskesmas) {
                return redirect('login')->with('success', 'Berhasil mendaftarkan akun. Harap menunggu validasi akun');
            } else {
                $user->delete();
                return redirect('login')->with('error', 'Gagal membuat akun puskesmas. Code [1]');
            }
        } else {
            $user->delete();
            return redirect('login')->with('error', 'Gagal membuat akun puskesmas. Code [2]');
        }
    }
}
