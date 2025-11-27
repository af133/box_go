<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    // INDEX: list semua order + lokasi + mitra
    public function index()
    {
        $orders = Order::with([
            'lokasi',
            'lokasi.mitra',
            'pelanggan',
            'jenis_barang'
        ])
        ->orderBy('id_order', 'desc')
        ->paginate(10);

        // Kembalikan VIEW (bukan JSON)
        return view('payment-order', compact('orders'));
    }

    // SHOW: detail satu order + lokasi + mitra (UNTUK AJAX)
    public function show($id)
    {
        try {
            $order = Order::with([
                'lokasi',
                'lokasi.mitra',
                'pelanggan',
                'jenis_barang'
            ])->findOrFail($id);

            // Return JSON untuk AJAX request
            return response()->json([
                'status' => true,
                'message' => 'Detail order',
                'data' => [
                    'id' => $order->id_order,
                    'pelanggan' => $order->pelanggan->nama ?? null,
                    'jenis_barang' => $order->jenis_barang->jenis_barang ?? null,
                    'nama_lokasi' => $order->lokasi->nama_lokasi ?? null,
                    'mitra' => $order->lokasi->mitra->nama ?? null,
                    'alamat_lokasi' => $order->lokasi->alamat ?? null,
                    'tanggal_penitipan' => $order->tanggal_penitipan,
                    'tanggal_pengembalian' => $order->tanggal_pengembalian,
                    'status' => $order->status,
                    'path_gambar' => $order->path_gambar,
                    'path_pembayaran' => $order->path_pembayaran,
                ]
            ], 200, [], JSON_UNESCAPED_SLASHES);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan: ' . $e->getMessage()
            ], 404);
        }
    }

    // APPROVE order
    public function approve($id)
    {
        try {
            Log::info("Approve order attempt for ID: " . $id);

            $order = Order::findOrFail($id);

            Log::info("Order found with status: " . $order->status);

            // Cek apakah sudah diproses
            if (strtolower($order->status) !== 'pending') {
                return response()->json([
                    'status' => false,
                    'message' => 'Order sudah diproses sebelumnya'
                ], 400);
            }

            // Update status dengan menggunakan update() langsung
            $order->update(['status' => 'Diterima']);

            Log::info("Order approved successfully");

            return response()->json([
                'status' => true,
                'message' => 'Order berhasil diterima'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Order not found: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            Log::error("Approve error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());

            return response()->json([
                'status' => false,
                'message' => 'Gagal menerima order: ' . $e->getMessage()
            ], 500);
        }
    }

    // REJECT order
    public function reject($id)
    {
        try {
            Log::info("Reject order attempt for ID: " . $id);

            $order = Order::findOrFail($id);

            Log::info("Order found with status: " . $order->status);

            // Cek apakah sudah diproses
            if (strtolower($order->status) !== 'pending') {
                return response()->json([
                    'status' => false,
                    'message' => 'Order sudah diproses sebelumnya'
                ], 400);
            }

            // Update status dengan menggunakan update() langsung
            $order->update(['status' => 'Ditolak']);

            Log::info("Order rejected successfully");

            return response()->json([
                'status' => true,
                'message' => 'Order berhasil ditolak'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Order not found: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            Log::error("Reject error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());

            return response()->json([
                'status' => false,
                'message' => 'Gagal menolak order: ' . $e->getMessage()
            ], 500);
        }
    }
}
