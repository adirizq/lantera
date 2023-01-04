<?php

namespace App\Http\Controllers;

use App\Models\Kader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function apiKaderLogin(Request $request)
    {
        $credentials  = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $user->tokens()->delete();
            $token = $user->createToken('user-token');

            if ($user->role == 2) {
                if (!isset($user->kader->verified_at)) {
                    return ['status' => 'fail', 'message' => "Akun belum tervalidasi harap hubungi admin puskesmas."];
                } else {
                    return ['status' => 'success', 'token' => $token->plainTextToken];
                }
            } else {
                return ['status' => 'fail', 'message' => "Anda bukan kader"];
            }
        } else {
            return ['status' => 'fail', 'message' => "Username atau password salah"];
        }
    }

    public function apiShow($hashToken)
    {
        $token = PersonalAccessToken::findToken($hashToken);
        $user = $token->tokenable;

        return $user;
    }

    public function apiShowKader($hashToken)
    {
        $token = PersonalAccessToken::findToken($hashToken);
        $user = $token->tokenable;

        $kader = Kader::where('user_id', $user->id)->with(['puskesmas'])->get();

        return $kader;
    }
}
