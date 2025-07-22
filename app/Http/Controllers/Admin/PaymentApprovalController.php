<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Bavix\Wallet\Models\Transaction;
use Illuminate\Http\Request;

class PaymentApprovalController extends Controller
{
    public function index()
    {
        // Fetch only transactions with status 'pending'
        $transactions = Transaction::where('status', 'pending')->latest()->paginate(15);

        return view('admin.payments.pending', compact('transactions'));
    }

    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'approved';
        $transaction->approved_by = auth()->id();
        $transaction->save();

        return back()->with('success', 'Payment approved.');
    }

    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'rejected';
        $transaction->approved_by = auth()->id();
        $transaction->save();

        return back()->with('success', 'Payment rejected.');
    }
}
