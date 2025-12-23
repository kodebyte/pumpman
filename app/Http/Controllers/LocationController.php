<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District; // Jika nanti pakai kecamatan

class LocationController extends Controller
{
    public function getCities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)->orderBy('name')->get();
        return response()->json($cities);
    }

    // Disiapkan untuk masa depan
    public function getDistricts($cityId)
    {
        $districts = District::where('city_id', $cityId)->orderBy('name')->get();
        return response()->json($districts);
    }
}