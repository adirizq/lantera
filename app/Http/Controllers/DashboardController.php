<?php

namespace App\Http\Controllers;

use App\Models\Kader;
use App\Models\Lansia;
use App\Models\Pemeriksaan;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if ($role == 0) {
            $puskesmas = Puskesmas::all();
            $kader_count = Kader::all()->count();
            $lansia_count = Lansia::all()->count();
            $pemeriksaan_count = Pemeriksaan::all()->count();

            $data_pemeriksaan = Pemeriksaan::selectRaw('year(created_at) year, month(created_at) month, count(*) data')
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->get();

            $data_pemeriksaan_by_month = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            foreach ($data_pemeriksaan as $data) {
                $data_pemeriksaan_by_month[($data->month) - 1] = $data->data;
            }

            $data_kader = Kader::selectRaw('puskesmas_id, count(*) data')
                ->groupBy('puskesmas_id')
                ->orderBy('puskesmas_id', 'asc')
                ->get();

            $data_kader_by_puskesmas = array();

            foreach ($puskesmas as $data) {
                array_push($data_kader_by_puskesmas, ['id' => $data->id, 'nama' => $data->nama_puskesmas, 'data' => 0]);
            }

            $kbp_d = '';
            $kbp_p = '';

            foreach ($data_kader as $data) {
                $key = array_search($data->puskesmas_id, array_column($data_kader_by_puskesmas, 'id'));
                $data_kader_by_puskesmas[$key]['data'] = $data->data;
            }

            foreach ($data_kader_by_puskesmas as $data) {
                $kbp_d .= $data['data'] . ',';
                $kbp_p .= '\'' . $data['nama'] . '\',';
            }

            $kbp_d = substr($kbp_d, 0, -1);
            $kbp_p = substr($kbp_p, 0, -1);

            return view('dashboard.admin.dashboard', [
                'page' => 'Dashboard',
                'puskesmas_count' => $puskesmas->count(),
                'kader_count' => $kader_count,
                'lansia_count' => $lansia_count,
                'pemeriksaan_count' => $pemeriksaan_count,
                'pbm' => $data_pemeriksaan_by_month,
                'kbp_d' => $kbp_d,
                'kbp_p' => $kbp_p,

            ]);
        } elseif ($role == 1) {
            $posyandu = Posyandu::where('puskesmas_id', auth()->user()->puskesmas->id)->get();
            $kader = Kader::where('puskesmas_id', auth()->user()->puskesmas->id)->get();
            $lansia = Lansia::whereIn('posyandu_id', $posyandu->pluck('id'))->get();
            $pemeriksaan_count = Pemeriksaan::whereIn('kader_id', $kader->pluck('id'))->count();

            $data_pemeriksaan = Pemeriksaan::selectRaw('year(created_at) year, month(created_at) month, count(*) data')
                ->whereIn('kader_id', $kader->pluck('id'))
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->get();

            $data_pemeriksaan_by_month = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            foreach ($data_pemeriksaan as $data) {
                $data_pemeriksaan_by_month[($data->month) - 1] = $data->data;
            }

            $data_lansia = Lansia::selectRaw('posyandu_id, count(*) data')
                ->whereIn('posyandu_id', $posyandu->pluck('id'))
                ->groupBy('posyandu_id')
                ->orderBy('posyandu_id', 'asc')
                ->get();

            $data_kader_by_posyandu = array();

            foreach ($posyandu as $data) {
                array_push($data_kader_by_posyandu, ['id' => $data->id, 'nama' => $data->nama, 'data' => 0]);
            }

            $kbp_d = '';
            $kbp_p = '';

            foreach ($data_lansia as $data) {
                $key = array_search($data->posyandu_id, array_column($data_kader_by_posyandu, 'id'));
                $data_kader_by_posyandu[$key]['data'] = $data->data;
            }

            foreach ($data_kader_by_posyandu as $data) {
                $kbp_d .= $data['data'] . ',';
                $kbp_p .= '\'' . $data['nama'] . '\',';
            }

            $kbp_d = substr($kbp_d, 0, -1);
            $kbp_p = substr($kbp_p, 0, -1);
            return view('dashboard.puskesmas.dashboard', [
                'page' => 'Dashboard',
                'posyandu_count' => $posyandu->count(),
                'kader_count' => $kader->count(),
                'lansia_count' => $lansia->count(),
                'pemeriksaan_count' => $pemeriksaan_count,
                'pbm' => $data_pemeriksaan_by_month,
                'kbp_d' => $kbp_d,
                'kbp_p' => $kbp_p,
            ]);
        }
    }
}
