<?php

namespace App\Http\Controllers;

use App\Models\RatingMitra;
use Illuminate\Auth\Events\Validated;
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
    public function AddKomentar(Request $request){
   $request->validate([
        'id_lokasi'=>'required',
        'rating' => 'required|integer|min:1|max:5',
        'review'=>'nullable|string',
        'id_pelanggan'=>'required'
   ]);

   RatingMitra::create([
        'id_lokasi' => $request->id_lokasi,
        'rating' => $request->rating,
        'review' => $request->review,
        'id_pelanggan' => $request->id_pelanggan,
   ]);

   $newAvgRating = RatingMitra::where('id_lokasi', $request->id_lokasi)->avg('rating');
   $datareview = RatingMitra::with('pelanggan')->where('id_lokasi',$request->id_lokasi)->get();

   return response()->json([
        'message' => 'Review berhasil dikirim',
        'reviews' => $datareview,
        'avg_rating' => round($newAvgRating, 1)
   ], 201);
}

    public function ShowKomentar(Request $request){
       $request->validate(
        [
            'id_lokasi'=>'required',
        ]);
        $review = RatingMitra::where('id_lokasi',$request->id_lokasi);
        return response()->json([
            'review'=>$review
        ]);
    }
}
