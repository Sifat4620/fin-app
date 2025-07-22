<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Models\Transfer;
use App\Models\Branch;
use App\Models\User;

class MyPaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        $transactions = Transaction::where('payable_type', get_class($user))
            ->where('payable_id', $user->id)
            ->latest()->paginate(10);

        $transfers = Transfer::where(function ($query) use ($user) {
            $query->where('from_id', $user->id)
                  ->orWhere('to_id', $user->id);
        })->latest()->paginate(10);

        return view('payments.my.index', compact('wallet', 'transactions', 'transfers'));
    }

    public function create()
    {
        $branches = Branch::all();
        $users = User::all();
        return view('payments.my.create', compact('branches','users'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'amount'             => 'required|numeric|min:1',
            'transaction_number' => 'required|string|max:255',
            'branch_id'          => 'required|exists:branches,id',
            'type'               => 'required|in:deposit,withdraw',
            'payment_date'       => 'required|date',
            'payment_month'      => 'required|string',
            'user_id'            => 'required|exists:users,id',
            'note'               => 'nullable|string'
        ]);

        // Get the user making the transaction (may be admin or self)
        $user = User::findOrFail($request->user_id);

        // Add extra transaction info
        $meta = [
            'transaction_number' => $request->transaction_number,
            'branch_id'          => $request->branch_id,
            'payment_date'       => $request->payment_date,
            'payment_month'      => $request->payment_month,
            'note'               => $request->note,
        ];

        // Make the transaction
        $transaction = $request->type === 'deposit'
            ? $user->deposit($request->amount, $meta)
            : $user->withdraw($request->amount, $meta);

        // Update extra fields on the transaction (custom DB columns)
        $transaction->transaction_number = $request->transaction_number;
        $transaction->status = 'pending';          // New field
        $transaction->approved_by = null;          // New field
        $transaction->save();

        return redirect()->route('my.payments.index')->with('success', 'DPS payment successful and pending approval.');
    }



    
}
