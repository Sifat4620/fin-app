@extends('main.master')

@section('title', 'Pending Payments')

@section('content')
<div class="content-body">
    <div class="container">

        <div class="row page-titles">
            <div class="col">
                <h4>Pending DPS Payments</h4>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Transaction Number</th>
                            <th>Type</th>
                            <th>Payment Date</th>
                            <th>Month</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($transactions as $txn)
                        <tr>
                            <td>{{ optional($txn->payable)->name }}</td>
                            <td>{{ $txn->amount }}</td>
                            <td>{{ $txn->transaction_number }}</td>
                            <td>{{ ucfirst($txn->type) }}</td>
                            <td>{{ $txn->meta['payment_date'] ?? '-' }}</td>
                            <td>{{ $txn->meta['payment_month'] ?? '-' }}</td>
                            <td>
                                <form action="{{ route('admin.payments.approve', $txn->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $txn->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No pending payments.</td></tr>
                    @endforelse
                    </tbody>
                </table>

                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
