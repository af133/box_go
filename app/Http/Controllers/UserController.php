<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Method to view all partners and customers
    public function viewUsers()
    {
        $partners = Mitra::all();
        $customers = Pelanggan::all();

        return response()->json([
            'partners' => $partners,
            'customers' => $customers,
        ]);
    }

    // Method to edit partner or customer details
    public function editUser(Request $request, $role, $id)
    {
        if ($role === 'mitra') {
            $user = Mitra::findOrFail($id);
        } elseif ($role === 'pelanggan') {
            $user = Pelanggan::findOrFail($id);
        } else {
            return response()->json(['message' => 'Invalid role.'], 400);
        }

        $user->update($request->all());

        return response()->json([
            'message' => ucfirst($role) . ' updated successfully.',
            'user' => $user,
        ]);
    }
}
