<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kader;
use App\Models\Lansia;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $id_puskesmas = auth()->user()->puskesmas->id;


            // Jumlah data posyandu, kader, lansia, dan pemeriksaan
            $posyandu = Posyandu::where('puskesmas_id', $id_puskesmas)->get();
            $kader = Kader::where('puskesmas_id', $id_puskesmas)->get();
            $lansia = Lansia::whereIn('posyandu_id', $posyandu->pluck('id'))->get();
            $pemeriksaan_count = Pemeriksaan::whereIn('kader_id', $kader->pluck('id'))->count();


            //Jumlah data pemeriksaan per tahun dan per bulan
            $pemeriksaan_per_tahun = DB::select("SELECT COUNT(p.id) AS 'total_data', year(p.created_at) AS 'p_year', month(p.created_at) AS 'p_month', pu.id AS 'puskesmas'  
            FROM pemeriksaan p 
            JOIN kader k ON kader_id = k.id 
            JOIN puskesmas pu ON k.puskesmas_id = pu.id 
            WHERE year(p.created_at) = year(curdate()) AND pu.id = :p_id
            GROUP BY p_year, p_month, puskesmas;", ['p_id' => $id_puskesmas]);

            $pemeriksaan_per_bulan = DB::select("SELECT COUNT(p.id) AS 'total_data', year(p.created_at) AS 'p_year', month(p.created_at) AS 'p_month', date(p.created_at) AS 'p_date' , pu.id AS 'puskesmas'
            FROM pemeriksaan p
            JOIN kader k ON kader_id = k.id 
            JOIN puskesmas pu ON k.puskesmas_id = pu.id
            WHERE year(p.created_at) = year(curdate()) AND month(p.created_at) = month(curdate()) AND pu.id = :p_id
            GROUP BY p_year, p_month, p_date, puskesmas;", ['p_id' => $id_puskesmas]);

            $this_month_days = cal_days_in_month(CAL_GREGORIAN, now()->month, now()->year);

            $pemeriksaan_per_tahun_count = array_fill(0, 12, 0);
            $pemeriksaan_per_bulan_count = array_fill(0, $this_month_days, 0);

            foreach ($pemeriksaan_per_tahun as $data) {
                $pemeriksaan_per_tahun_count[($data->p_month) - 1] = $data->total_data;
            }

            foreach ($pemeriksaan_per_bulan as $data) {
                $pemeriksaan_per_bulan_count[(explode('-', $data->p_date)[2]) - 1] = $data->total_data;
            }


            //Data pemeriksaan + lansia + lokasi + score
            $data_lansia_lengkap = collect(DB::select("WITH ranked_pemeriksaan AS (
                SELECT p.id, ROW_NUMBER() OVER (PARTITION BY lansia_id ORDER BY created_at DESC) AS rp, p.lansia_id, p.longitude, p.latitude, p.kader_id
                FROM pemeriksaan AS p
              )
              SELECT r.*, l.nama, l.alamat_domisili, po.nama AS 'nama_posyandu', s.status_malnutrisi, s.status_penglihatan,s.status_pendengaran, s.status_mobilitas, s.status_kognitif, s.status_gejala_depresi FROM ranked_pemeriksaan AS r
                  JOIN lansia AS l ON r.lansia_id = l.id
                  JOIN posyandu AS po ON l.posyandu_id = po.id
                  JOIN view_scores AS s ON s.pemeriksaan_id = r.id
                  JOIN kader AS k ON r.kader_id = k.id 
                  JOIN puskesmas AS pu ON k.puskesmas_id = pu.id
                  WHERE rp = 1 AND pu.id = :p_id 
                  ORDER BY r.id DESC;", ['p_id' => $id_puskesmas]));


            $data_lansia_dengan_gangguan = $data_lansia_lengkap->filter(function ($value, $key) {
                return
                    $value->status_malnutrisi == 'GANGGUAN' ||
                    $value->status_penglihatan == 'GANGGUAN' ||
                    $value->status_pendengaran == 'GANGGUAN' ||
                    $value->status_mobilitas == 'GANGGUAN' ||
                    $value->status_kognitif == 'GANGGUAN' ||
                    $value->status_gejala_depresi == 'GANGGUAN';
            });

            $data_lokasi_lansia = $data_lansia_lengkap->map(
                function ($item, $key) {
                    return collect($item)->only(['nama', 'longitude', 'latitude'])->toArray();
                }
            )->toArray();


            //Data per kategori kesehatan
            $data_malnutrisi = [
                $data_lansia_lengkap->where('status_malnutrisi', 'NORMAL')->count(),
                $data_lansia_lengkap->where('status_malnutrisi', 'BERESIKO')->count(),
                $data_lansia_lengkap->where('status_malnutrisi', 'GANGGUAN')->count(),
            ];

            $data_penglihatan = [
                $data_lansia_lengkap->where('status_penglihatan', 'NORMAL')->count(),
                $data_lansia_lengkap->where('status_penglihatan', 'BERESIKO')->count(),
                $data_lansia_lengkap->where('status_penglihatan', 'GANGGUAN')->count(),
            ];

            $data_pendengaran = [
                $data_lansia_lengkap->where('status_pendengaran', 'NORMAL')->count(),
                $data_lansia_lengkap->where('status_pendengaran', 'BERESIKO')->count(),
                $data_lansia_lengkap->where('status_pendengaran', 'GANGGUAN')->count(),
            ];

            $data_mobilitas = [
                $data_lansia_lengkap->where('status_mobilitas', 'NORMAL')->count(),
                $data_lansia_lengkap->where('status_mobilitas', 'BERESIKO')->count(),
                $data_lansia_lengkap->where('status_mobilitas', 'GANGGUAN')->count(),
            ];

            $data_kognitif = [
                $data_lansia_lengkap->where('status_kognitif', 'NORMAL')->count(),
                $data_lansia_lengkap->where('status_kognitif', 'BERESIKO')->count(),
                $data_lansia_lengkap->where('status_kognitif', 'GANGGUAN')->count(),
            ];

            $data_gejala_depresi = [
                $data_lansia_lengkap->where('status_gejala_depresi', 'NORMAL')->count(),
                $data_lansia_lengkap->where('status_gejala_depresi', 'BERESIKO')->count(),
                $data_lansia_lengkap->where('status_gejala_depresi', 'GANGGUAN')->count(),
            ];

            return view('dashboard.puskesmas.dashboard', [
                'page' => 'Dashboard',
                'posyandu_count' => $posyandu->count(),
                'kader_count' => $kader->count(),
                'lansia_count' => $lansia->count(),
                'pemeriksaan_count' => $pemeriksaan_count,
                'total_days' => $this_month_days,
                'ppt' => $pemeriksaan_per_tahun_count,
                'ppb' => $pemeriksaan_per_bulan_count,
                'ldg' => $data_lansia_dengan_gangguan,
                'lokasi_lansia' => $data_lokasi_lansia,
                'data_malnutrisi' => $data_malnutrisi,
                'data_penglihatan' => $data_penglihatan,
                'data_pendengaran' => $data_pendengaran,
                'data_mobilitas' => $data_mobilitas,
                'data_kognitif' => $data_kognitif,
                'data_gejala_depresi' => $data_gejala_depresi,
            ]);
        }
    }
}
