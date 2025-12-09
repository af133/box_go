<?php

namespace App\Http\Controllers;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Lokasi;
use App\Models\ItemOrder;
use App\Models\HargaMitra;
use App\Models\PenarikanDana;

class OrderController extends Controller
{
    public function AddOrder(Request $request)
    {
        $validate = $request->validate([
            'id_pelanggan'          => 'required',
            'id_lokasi'             => 'required',
            'path_gambar'           => 'required|mimes:jpg,jpeg,png',
            'path_pembayaran'       => 'required|mimes:jpg,jpeg,png',
            'id_jenis_barang'       => 'required|array',
            'tanggal_penitipan'     => 'required|date',
            'tanggal_pengembalian'  => 'required|date',
        ]);

        $gambarUrl = Cloudinary::upload(
            $request->file('path_gambar')->getRealPath()
        )->getSecurePath();

        $pembayaranUrl = Cloudinary::upload(
            $request->file('path_pembayaran')->getRealPath()
        )->getSecurePath();

        foreach ($request->id_jenis_barang as $jenis_barang) {
            Order::create([
                'id_pelanggan'          => $request->id_pelanggan,
                'id_lokasi'             => $request->id_lokasi,
                'path_gambar'           => $gambarUrl,
                'path_pembayaran'       => $pembayaranUrl,
                'id_jenis_barang'       => $jenis_barang,
                'tanggal_penitipan'     => $request->tanggal_penitipan,
                'tanggal_pengembalian'  => $request->tanggal_pengembalian,
                'status'                => 'pending',
            ]);
        }

        return response()->json(['message' => 'Order berhasil dibuat']);
    }
    public function ShowOrder(Request $request)
    {
        $orders = Order::where('id_pelanggan', $request->id_pelanggan)->get();

        return response()->json(['orders' => $orders]);
    }
   public function ShowAllOrdersMitra(Request $request)
    {
        $request->validate([
            'id_mitra' => 'required',
        ]);
        $id_lokasi = Lokasi::where('id_mitra', $request->id_mitra)->pluck('id_lokasi');
        $orders = Order::with([
                'pelanggan',
                'lokasi',
                'item_orders.jenisBarang'
            ])
            ->whereIn('id_lokasi', $id_lokasi)
            ->orderByDesc('id_order')
            ->get();
        $total_orders = $orders->count();
        $id_order = $orders->pluck('id_order');
        $total_penghasilan = ItemOrder::whereIn('id_order', $id_order)
            ->sum('harga_saat_order');
        $penarikan_dana = PenarikanDana::where('id_mitra', $request->id_mitra)
            ->where('status', 'Diterima')
            ->sum('jumlah_penarikan');
        $saldo_tersedia = $total_penghasilan - $penarikan_dana;
        $orders->transform(function ($order) {
            $order->jumlah_item = $order->item_orders->count();
            $order->total_harga = $order->item_orders->sum('harga_saat_order');
            return $order;
        });
        return response()->json([
            'total_orders'      => $total_orders,
            'total_penghasilan' => $total_penghasilan,
            'saldo_tersedia'    => $saldo_tersedia,
            'orderanNow'        => $orders->take(5)->values(),
            'orderAll'          => $orders->values(),
        ]);
    }
}
