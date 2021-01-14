<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function checkLocation(Request $request)
    {
        $defaultLat = 20.980885;
        $defaultLong = 105.789046;

        $data = $request->all();
        $radLatDefault = pi() * $defaultLat / 180;
        $radLatCurrent = pi() * $data['lat'] / 180;
        $theta = $defaultLong - $data['long'];
        $radTheta = pi() * $theta / 180;
        $dist = sin($radLatDefault) * sin($radLatCurrent) + cos($radLatDefault) * cos($radLatCurrent) * cos($radTheta);
        if ($dist > 1) {
            $dist = 1;
        }
        $dist = acos($dist) * 180 / pi();
        //distance - miles
        $miles = $dist * 60 * 1.1515;
        //distance - km
        $km = $miles * 1.609344;
        //distance - meters
        $m = $km * 1000;
        if ($m < $data['distance_allow']) {
            return response()->json([
                "status" => 1,
                "distance" => $m
            ]);
        }
        return response()->json([
            "status" => 0,
            "distance" => $m
        ]);
    }
}
