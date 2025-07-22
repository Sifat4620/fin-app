<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->paginate(15);
        return view('invoice.index', compact('invoices'));
    }

    public function create()
    {
        $transactions = Transaction::latest()->limit(50)->get();
        $users = User::select('id', 'name')->orderBy('name')->get();
        $wallets = Wallet::select('id', 'holder_id', 'balance')->get();

        return view('invoice.create', compact('transactions', 'users', 'wallets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_date' => 'required|date',
            'amount' => 'required|numeric',
            'amount_in_words' => 'required|string',
            'payment_month' => 'required|string',
            'receiver_name' => 'required|string',
            'sender_name' => 'required|string',
            'transaction_number' => 'nullable|string|exists:transactions,transaction_number',
            'sign_1_name' => 'nullable|string',
            'sign_2_name' => 'nullable|string',
            'sign_3_name' => 'nullable|string',
        ]);

        Invoice::create($request->all());

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoice.show', compact('invoice'));
    }

    public function edit(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $transactions = Transaction::latest()->limit(50)->get();
        return view('invoice.edit', compact('invoice', 'transactions'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'invoice_date' => 'required|date',
            'amount' => 'required|numeric',
            'amount_in_words' => 'required|string',
            'payment_month' => 'required|string',
            'receiver_name' => 'required|string',
            'sender_name' => 'required|string',
            'transaction_number' => 'nullable|string|exists:transactions,transaction_number',
            'sign_1_name' => 'nullable|string',
            'sign_2_name' => 'nullable|string',
            'sign_3_name' => 'nullable|string',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function print(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoice.print', compact('invoice'));
    }
}
