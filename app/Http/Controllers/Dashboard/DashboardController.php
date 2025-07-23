<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Branch;

class DashboardController extends Controller
{
    public function index()
    {
        // Recent 5 records
        $recentUsers = User::latest()->take(5)->get();
        $recentTransactions = Transaction::latest()->take(5)->get();

        // Summary counts
        $counts = [
            'total_users' => User::count(),
            'total_transactions' => Transaction::count(),
            'total_branches' => Branch::count(),
            'total_wallets' => Wallet::count(),
            'total_balance' => Wallet::sum('balance'),
        ];

        return view('dashboard', compact(
            'recentUsers',
            'recentTransactions',
            'counts'
        ));
    }
}
