<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;
use App\Models\Lokasi;
class MitraBarang extends Controller
{
    public function ShowBarangMitra(){
        $lokasi=Lokasi::with(['area_gudang.polygon','mitra.harga_mitra.jenis_barang'])->get();
        return response()->json([
            'lokasi'=>$lokasi
        ]);
    }
}
