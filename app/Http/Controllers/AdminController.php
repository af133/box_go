<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Method to confirm payment
    public function confirmPayment(Request $request, $transactionId)
    {
        $transaction = Transaksi::findOrFail($transactionId);

        if ($transaction->status !== 'pending') {
            return response()->json(['message' => 'Transaction is not pending.'], 400);
        }

        $transaction->status = 'confirmed';
        $transaction->save();

        return response()->json(['message' => 'Payment confirmed successfully.']);
    }

    // Method to confirm fund withdrawal for a partner
    public function confirmWithdrawal(Request $request, $partnerId)
    {
        $partner = Mitra::findOrFail($partnerId);

        if ($partner->withdrawal_status !== 'pending') {
            return response()->json(['message' => 'Withdrawal is not pending.'], 400);
        }

        $partner->withdrawal_status = 'confirmed';
        $partner->save();

        return response()->json(['message' => 'Withdrawal confirmed successfully.']);
    }
}
