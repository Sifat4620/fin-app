<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Yearly user payment summary
    public function yearlyUserPayments()
    {
        $yearlyData = Transaction::select(
                DB::raw('YEAR(transactions.created_at) as year'),
                'transactions.created_at',
                'transactions.amount',
                'transactions.transaction_number',
                'transactions.type',
                'users.id as user_id',
                'users.name as user_name',
                'users.email',
                'users.nid_number'
            )
            ->join('wallets', 'wallets.id', '=', 'transactions.wallet_id')
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'wallets.holder_id')
                    ->where('wallets.holder_type', '=', User::class);
            })
            ->where('transactions.type', 'deposit')
            ->orderBy('year', 'desc')
            ->orderBy('users.name')
            ->orderBy('transactions.created_at', 'desc')
            ->get()
            ->groupBy(['year', 'user_id']);

        return view('reports.yearly_user_payments', compact('yearlyData'));
    }

    // Monthly user payment summary
    public function monthlyUserPayments()
    {
        $monthlyData = Transaction::select(
                DB::raw("DATE_FORMAT(transactions.created_at, '%Y-%m') as month"),
                'transactions.created_at',
                'transactions.amount',
                'transactions.transaction_number',
                'transactions.type',
                'users.id as user_id',
                'users.name as user_name',
                'users.email',
                'users.nid_number'
            )
            ->join('wallets', 'wallets.id', '=', 'transactions.wallet_id')
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'wallets.holder_id')
                    ->where('wallets.holder_type', '=', User::class);
            })
            ->where('transactions.type', 'deposit')
            ->orderBy('month', 'desc')
            ->orderBy('users.name')
            ->orderBy('transactions.created_at', 'desc')
            ->get()
            ->groupBy(['month', 'user_id']);

        return view('reports.monthly_user_payments', compact('monthlyData'));
    }

    // Invoice report
    public function invoices()
    {
        $invoices = Invoice::latest()->paginate(20); // or ->get() if no pagination needed
        return view('reports.invoices', compact('invoices'));
    }

    // Optional: Client report
    public function clients()
    {
        $clients = User::whereNotNull('nid_number')->get(); // customize logic if needed
        return view('reports.clients', compact('clients'));
    }




    public function graph()
    {
        $monthlyTotals = \App\Models\Transaction::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw("SUM(amount) as total")
            )
            ->where('type', 'deposit')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('reports.graph', compact('monthlyTotals'));
    }
}
