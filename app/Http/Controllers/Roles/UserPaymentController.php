<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserPaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get wallet
        $wallet = $user->wallet;

        // Get all transactions
        $transactions = $user->transactions()->latest()->get();

        // Calculate totals
        $totalDeposited = $transactions->where('type', 'deposit')->sum('amount');
        $totalWithdrawn = $transactions->where('type', 'withdraw')->sum('amount');
        $currentBalance = $wallet ? $wallet->balance : 0;

        // Current month payment summary
        $currentMonth = now()->format('Y-m');
        $paidThisMonth = $transactions->where('type', 'deposit')->filter(function ($txn) use ($currentMonth) {
            return $txn->created_at->format('Y-m') === $currentMonth;
        })->sum('amount');

        return view('reports.my_payments', compact(
            'wallet',
            'transactions',
            'totalDeposited',
            'totalWithdrawn',
            'currentBalance',
            'paidThisMonth'
        ));
    }
}
