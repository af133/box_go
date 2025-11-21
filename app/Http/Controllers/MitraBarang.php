<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;
class MitraBarang extends Controller
{
    public function ShowBarangMitra(Request $request){
        $latitude  = $request->latitude;
        $longitude = $request->longitude;
        $terdekat = Lokasi::with(['mitra'])
            ->select('*')
            ->selectRaw("(
                6371 * acos(
                    cos(radians(?)) * cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(latitude))
                )
            ) AS distance", [$latitude, $longitude, $latitude])
            ->orderBy('distance', 'ASC')
            ->limit(10)
            ->get();
        $ratingTertinggi = Lokasi::with(['mitra'])
            ->withAvg('ratingMitra', 'rating')
            ->orderBy('rating_mitra_avg_rating', 'DESC')
            ->limit(10)
            ->get();

        return response()->json([
            'penitipan_terdekat' => $terdekat,
            'rating_tertinggi' => $ratingTertinggi
        ]);
       
    }
}
