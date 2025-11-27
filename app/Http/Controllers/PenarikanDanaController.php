<?php

namespace App\Http\Controllers;

use App\Models\PenarikanDana;
use Illuminate\Http\Request;

class PenarikanDanaController extends Controller
{
    /**
     * Menampilkan semua data penarikan dana
     */
    public function index()
    {
        $penarikan = PenarikanDana::with('mitra')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $penarikan
        ]);
    }

    /**
     * Membuat pengajuan penarikan dana baru
     */
    public function create(Request $request)
    {
        $request->validate([
            'id_mitra' => 'required|exists:mitras,id_mitra',
            'tanggal_penarikan' => 'required|date',
            'jumlah_penarikan' => 'required|numeric|min:1000',
            'alasan_penarikan' => 'nullable|string',
        ]);

        $data = PenarikanDana::create([
            'id_mitra' => $request->id_mitra,
            'tanggal_penarikan' => $request->tanggal_penarikan,
            'jumlah_penarikan' => $request->jumlah_penarikan,
            'alasan_penarikan' => $request->alasan_penarikan,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan penarikan berhasil dibuat.',
            'data' => $data
        ]);
    }

    /**
     * Approve penarikan dana
     */
    public function approve($id)
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
     * Reject penarikan dana
     */
    public function reject($id)
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
