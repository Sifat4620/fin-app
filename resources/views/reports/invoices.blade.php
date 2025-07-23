@extends('main.master')

@section('title', 'Invoice Report')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">📑 Invoice Report</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Invoice Date</th>
                            <th>Receiver</th>
                            <th>Amount</th>
                            <th>Transaction #</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</td>
                                <td>{{ $invoice->receiver_name }}</td>
                                <td>{{ number_format($invoice->amount) }} BDT</td>
                                <td>{{ $invoice->transaction_number ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No invoices found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $invoices->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
