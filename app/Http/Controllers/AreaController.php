<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\IndonesiaService;

class AreaController extends Controller
{
    public function getCities($id)
    {
        $cities = \Indonesia::findProvince($id, ['cities'])->cities;

        return response()->json($cities);
    }

    public function getDistricts($id)
    {
        $districts = \Indonesia::findCity($id, ['districts'])->districts;

        return response()->json($districts);
    }

    public function getVillages($id)
    {
        $villages = \Indonesia::findDistrict($id, ['villages'])->villages;

        return response()->json($villages);
    }
}
