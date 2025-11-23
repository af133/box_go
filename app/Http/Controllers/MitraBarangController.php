<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Log;

class MitraBarangController extends Controller
{
    public function ShowBarangMitra(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $latitude  = $request->latitude;
        $longitude = $request->longitude;

        try {
            $terdekat = Lokasi::with(['mitra'])
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->select('*')
                ->selectRaw("(
                    6371 * acos(
                        cos(radians(?)) * cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) * sin(radians(latitude))
                    )
                ) AS distance", [$latitude, $longitude, $latitude])
                ->orderBy('distance', 'ASC')
                ->get();

            // Ambil rating tertinggi
            $ratingTertinggi = Lokasi::with(['mitra'])
                ->withAvg('rating_mitra', 'rating')
                ->orderBy('rating_mitra_avg_rating', 'DESC')
                ->get();

            $merged = [];

            foreach ($terdekat as $t) {
                $id = $t->id_lokasi;
                $merged[$id] = $t->toArray();
                $merged[$id]['rating_mitra_avg_rating'] = 0;
            }

            foreach ($ratingTertinggi as $r) {
                $id = $r->id_lokasi;
                if (isset($merged[$id])) {
                    $merged[$id]['rating_mitra_avg_rating'] = $r->rating_mitra_avg_rating ?? 0;
                } else {
                    $merged[$id] = $r->toArray();
                    $merged[$id]['distance'] = null;
                }
            }
            $mergedArray = array_values($merged);

            return response()->json([
                'mitra' => $mergedArray
            ]);

        } catch (\Exception $e) {
            Log::error('Error dashboard lokasi: '.$e->getMessage());
            return response()->json([
                'mitra' => []
            ]);
        }
    }
}
