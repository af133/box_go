<?php

namespace App\Http\Controllers;
use Cloudinary\Cloudinary;
use App\Models\HargaMitra;
use App\Models\RatingMitra;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\Lokasi;
use App\Models\Polygon;
use App\Models\JenisBarang;
use App\Models\AreaGudang;
use Illuminate\Support\Facades\Log;
use Validator;
class LokasiMitraController extends Controller
{
    public function ShowLokasiMitra(Request $request)
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
    public function JenisBarang(Request $request){
        $request->validate([
            'id_mitra'=>'required'
        ]);
        $data = HargaMitra::with('jenis_barang')->where('id_mitra', $request->id_mitra)->get()->map(function($item){
        return [
            'id_harga_mitra' => $item->id_harga_mitra,
            'id_jenis_barang' => $item->id_jenis_barang,
            'jenis_barang' => $item->jenis_barang->jenis_barang ?? '',
            'harga_sewa' => $item->harga_sewa
        ];
    });


        return response()->json([
            'jenisBarang'=>$data
        ]);
    }
     public function AddLokasiMitra(Request $request){
    $validator = Validator::make($request->all(), [
            'id_mitra' => 'required',
            'nama_lokasi' => 'required|string',
            'deskripsi' => 'required|string',
            'path_area' => 'required|mimes:jpg,jpeg,png|file|max:2048',
        ], [
            'nama_lokasi.required' => 'Wajib mengisi nama lokasi',
            'path_area.required' => 'Wajib upload gambar',
            'path_area.mimes' => 'Gambar harus bertipe png, jpg, jpeg',
            'path_area.max' => 'Ukuran gambar maksimal 2MB',
            'deskripsi.required' => 'Wajib mengisi deskripsi lokasi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // 422 = Unprocessable Entity
        }

        $cloudinaryUrl = null;
        if ($request->hasFile('path_area')) {
            $cloudinary = new Cloudinary();
            $cloudinaryResult = $cloudinary->uploadApi()->upload(
                $request->file('path_area')->getRealPath(),
                [
                    'folder' => 'go_box/'.$request->id_mitra
                ]
            );
            $cloudinaryUrl = $cloudinaryResult['secure_url'] ?? null;
        }

        $lokasiMitra = Lokasi::create([
            'id_mitra' => $request->id_mitra,
            'nama_lokasi' => $request->nama_lokasi,
            'deskripsi' => $request->deskripsi,
            'path_area' => $cloudinaryUrl,
        ]);

        return response()->json([
            'success' => true,
            'lokasi' => $lokasiMitra
        ], 200);
    }
    public function UpdateJenisBarang(Request $request){
        Log::info('UpdateJenisBarang request: ', $request->all());
        $request->validate([
            'id_jenis_barang'=>'required',
            'jenis_barang'=>'required',
            'harga_sewa'=>'required',
        ]);

        JenisBarang::where('id_jenis_barang',$request->id_jenis_barang)->update([
            'jenis_barang'=>$request->jenis_barang
        ]);
        $hargaSewa= $request->harga_sewa;
        HargaMitra::where('id_jenis_barang',$request->id_jenis_barang)->update([
            'harga_sewa'=>$hargaSewa
        ]);
        return response()->json([
            'message'=>'Jenis barang berhasil diupdate',
        ],200);
    }
    public function UpdateLokasi(Request $request){
    $request->validate([
            'id_lokasi'=>'required',
            'nama_lokasi'=>'required',
            'deskripsi'=>'required',
            'path_area'=>'nullable|mimes:jpg,jpeg,png|file|max:2048',
        ]);

        $lokasi = Lokasi::findOrFail($request->id_lokasi);

        $cloudinaryUrl = $lokasi->path_area;

        if ($request->hasFile('path_area')) {
            $cloudinary = new Cloudinary();

            $cloudinaryResult = $cloudinary->uploadApi()->upload(
                $request->file('path_area')->getRealPath(),
                [
                    'folder' => 'go_box/'.$request->id_mitra
                ]
            );

            $cloudinaryUrl = $cloudinaryResult['secure_url'] ?? $lokasi->path_area;
        }

        Lokasi::where('id_lokasi', $request->id_lokasi)->update([
            'id_mitra'   => $lokasi->id_mitra,
            'nama_lokasi'=> $request->nama_lokasi,
            'deskripsi'  => $request->deskripsi,
            'path_area'  => $cloudinaryUrl,
        ]);

        return response()->json([
            'message'=>'Lokasi berhasil diupdate',
        ],200);
    }


    public function AddPolygon(Request $request){
        $request->validate([
            'id_lokasi'=>'required',
            'polygon'=>'required'
        ]);
        $lokasi = Lokasi::where('id_lokasi',$request->id_lokasi)->first();
        if(!$lokasi){
            return response()->json([
                'message'=>'Lokasi tidak ditemukan'
            ],404);
        }
        $poligon=Polygon ::create([
            'polygon'=>$request->polygon
        ]);
        AreaGudang::create([
            'id_lokasi'=>$lokasi->id_lokasi,
            'id_polygon'=>$poligon->id_polygon
        ]);
        return response()->json([
            'message'=>'Polygon berhasil ditambahkan',
            'lokasi'=>$lokasi
        ],200);
    }
    public function ShowLokasiMitraByIdMitra(Request $request){
        $request->validate([
            'id_mitra'=>'required'
        ]);

        $lokasi = Lokasi::where('id_mitra',$request->id_mitra)->get();
        return response()->json([
            'lokasi'=>$lokasi,
        ],200);
    }
    public function AddJenisBarang(Request $request){
        \Log::info('AddJenisBarang request: ', $request->all());

        // Validasi
        $request->validate([
            'id_mitra' => 'required|integer',
            'jenis_barang' => 'required|string',
            'harga_sewa' => 'required|integer'
        ]);

        try {
            // Simpan jenis barang
            $jenisBarang = JenisBarang::create([
                'jenis_barang' => $request->jenis_barang
            ]);

            // Simpan harga sewa untuk mitra
            HargaMitra::create([
                'id_mitra' => $request->id_mitra,
                'id_jenis_barang' => $jenisBarang->id_jenis_barang,
                'harga_sewa' => $request->harga_sewa
            ]);

            return response()->json([
                'message' => 'Jenis barang berhasil ditambahkan',
                'data' => [
                    'id_jenis_barang' => $jenisBarang->id_jenis_barang,
                    'jenis_barang' => $jenisBarang->jenis_barang,
                    'harga_sewa' => $request->harga_sewa
                ]
            ], 200);

        } catch (\Exception $e) {
            \Log::error('AddJenisBarang error: '.$e->getMessage());
            return response()->json([
                'message' => 'Terjadi error saat menambahkan jenis barang',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function LokasiDetail($id_lokasi)
    {
        $lokasi = Lokasi::find($id_lokasi);
        if (!$lokasi) {
            return response()->json(['message' => 'Lokasi tidak ditemukan'], 404);
        }

        $area_gudang = AreaGudang::with('polygon')->where('id_lokasi', $id_lokasi)->get();

        return response()->json([
            'id_lokasi' => $lokasi->id_lokasi,
            'id_mitra' => $lokasi->id_mitra,
            'nama_lokasi' => $lokasi->nama_lokasi,
            'deskripsi' => $lokasi->deskripsi,
            'alamat' => $lokasi->alamat,
            'path_area' => $lokasi->path_area,
            'latitude' => $lokasi->latitude,
            'longitude' => $lokasi->longitude,
            'area' => $area_gudang->map(function ($a) {
                return [
                    'id_area' => $a->id_area,
                    'id_polygon' => $a->id_polygon,
                    'polygon' => $a->polygon->polygon ?? null,
                ];
            }),
        ]);
    }
    public function UpdateOrAddLokasiAndPolygon(Request $request)
{
    \Log::info("==== UPDATE LOKASI & POLYGON MULAI ====");

    try {
        \Log::info("REQUEST DATA:", $request->all());

        $request->validate([
            'id_lokasi' => 'required|exists:lokasi,id_lokasi',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'polygons' => 'nullable|array',
            'polygons.*.id_polygon' => 'nullable|exists:polygon,id_polygon',
            'polygons.*.polygon' => 'nullable|string',
        ]);

        \Log::info("VALIDATION PASSED");

        // 1. Update lokasi
        $lokasi = Lokasi::find($request->id_lokasi);

        if (!$lokasi) {
            \Log::error("Lokasi tidak ditemukan ID: {$request->id_lokasi}");
            return response()->json(['error' => 'Lokasi tidak ditemukan'], 404);
        }

        $lokasi->latitude = $request->latitude;
        $lokasi->longitude = $request->longitude;
        $lokasi->save();

        \Log::info("Lokasi berhasil diupdate", $lokasi->toArray());

        // 2. Update / tambah polygon
        $updatedPolygons = [];

        foreach ($request->polygons as $polyData) {
            \Log::info("Processing polygon:", $polyData);

            // Jika punya id_polygon → update
            if (!empty($polyData['id_polygon'])) {
                $polygon = Polygon::find($polyData['id_polygon']);

                if (!$polygon) {
                    \Log::error("Polygon ID {$polyData['id_polygon']} tidak ditemukan");
                    continue;
                }

                $polygon->polygon = $polyData['polygon'];
                $polygon->save();

                \Log::info("Polygon UPDATED:", $polygon->toArray());
                $updatedPolygons[] = $polygon;
            }

            // Kalau tidak → create
            else {
                $polygon = Polygon::create([
                    'polygon' => $polyData['polygon'],
                ]);

                AreaGudang::create([
                    'id_lokasi' => $lokasi->id_lokasi,
                    'id_polygon' => $polygon->id_polygon,
                ]);

                \Log::info("Polygon CREATED dan dihubungkan:", $polygon->toArray());
                $updatedPolygons[] = $polygon;
            }
        }

        \Log::info("==== UPDATE LOKASI & POLYGON SELESAI ====");

        return response()->json([
            'message' => 'Lokasi dan Polygon berhasil diupdate',
            'lokasi' => $lokasi,
            'polygons' => $updatedPolygons,
        ], 200);
    }

    catch (\Throwable $e) {
        \Log::error("ERROR UPDATE LOKASI & POLYGON", [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'error' => 'Terjadi kesalahan server',
            'detail' => $e->getMessage()
        ], 500);
    }
}






}
