<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Method to view all partners and customers
    public function viewUsers()
    {
        $partners = Mitra::with('email')
            ->OrderBy('id_mitra', 'asc')
            ->get();
        $customers = Pelanggan::with('email')
            ->OrderBy('id_pelanggan', 'asc')
            ->get();

        return response()->json([
            'partners' => $partners,
            'customers' => $customers,
        ]);
    }

    // Method to edit partner or customer details
    public function editUser(Request $request, $role, $id)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'nama' => 'nullable|string|max:255',
                'email' => 'nullable|exists:email,email',
                'nomor_hp' => 'nullable|string|max:15',
                'alamat' => 'nullable|string|max:255',
            ]);

            // Find the user based on the role
            if ($role === 'mitra') {
                $user = Mitra::findOrFail($id);
            } elseif ($role === 'pelanggan') {
                $user = Pelanggan::findOrFail($id);
            } else {
                return response()->json(['message' => 'Invalid role.'], 400);
            }

            // Update the user
            $user->update($validatedData);

            return response()->json([
                'message' => ucfirst($role) . ' updated successfully.',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            // Log the error and return a 500 response
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while updating the user.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
