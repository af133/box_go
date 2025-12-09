<?php

namespace App\Http\Controllers;

use App\Models\PenarikanDana;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenarikanDanaController extends Controller
{
    /**
     * Menampilkan semua data penarikan dana (untuk admin)
     */
    public function index()
    {
        $penarikan = PenarikanDana::with('mitra')
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $penarikan
        ]);
    }

    /**
     * Menampilkan saldo gabungan penarikan & pemasukan untuk mitra tertentu
     */
    public function showSaldoMitra(Request $request, int $idMitra)
    {
        // Penarikan dana milik mitra
        $penarikan = PenarikanDana::where('id_mitra', $idMitra)
            ->select([
                'id as id_transaksi',
                DB::raw("'penarikan' as type"),
                'jumlah_penarikan as jumlah',
                'tanggal_penarikan as tanggal',
                'status'
            ])
            ->get();

        // Pemasukan dari order yang diterima
        $pemasukan = Order::whereHas('lokasi', fn($q) => $q->where('id_mitra', $idMitra))
            ->where('status', 'Diterima')
            ->join('item_order', 'orders.id_order', '=', 'item_order.id_order')
            ->select([
                'orders.id_order as id_transaksi',
                DB::raw("'pemasukan' as type"),
                DB::raw('SUM(item_order.harga_saat_order) as jumlah'),
                'tanggal_pengambilan as tanggal',
                DB::raw("'Diterima' as status")
            ])
            ->groupBy('orders.id_order', 'tanggal_pengambilan')
            ->get();

        // Gabungkan dan urutkan berdasarkan tanggal terbaru
        $saldo = $penarikan->concat($pemasukan)
            ->sortByDesc('tanggal')
            ->values();

        return response()->json([
            'success' => true,
            'data' => $saldo
        ]);
    }

    /**
     * Membuat pengajuan penarikan dana baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_mitra' => 'required|exists:mitras,id_mitra',
            'tanggal_penarikan' => 'required|date',
            'jumlah_penarikan' => 'required|numeric|min:1000',
            'alasan_penarikan' => 'nullable|string',
        ]);

        $penarikan = PenarikanDana::create(array_merge($validated, [
            'status' => 'pending'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan penarikan berhasil dibuat.',
            'data' => $penarikan
        ]);
    }

    /**
     * Menyetujui penarikan dana
     */
    public function approve(int $id)
    {
        $penarikan = PenarikanDana::findOrFail($id);

        if ($penarikan->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid untuk disetujui.'
            ], 400);
        }

        $penarikan->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Penarikan dana disetujui.',
            'data' => $penarikan
        ]);
    }

    /**
     * Menolak penarikan dana
     */
    public function reject(int $id)
    {
        $penarikan = PenarikanDana::findOrFail($id);

        if ($penarikan->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid untuk ditolak.'
            ], 400);
        }

        $penarikan->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Penarikan dana ditolak.',
            'data' => $penarikan
        ]);
    }
}
