@extends('main.master')

@section('title', 'Yearly User Payments')

@section('content')
<div class="content-body">
    <div class="container">

        <!-- Page Title & Breadcrumb -->
        <div class="row page-titles mb-3">
            <div class="col">
                <h4 class="mb-0">📊 Yearly User Payments Report</h4>
                <small class="text-muted">Detailed breakdown by year and user</small>
            </div>
        </div>

        @forelse($yearlyData as $year => $users)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Year: {{ $year }}</h5>
                </div>
                <div class="card-body">

                    @forelse($users as $userId => $transactions)
                        <div class="mb-4">
                            <h6>
                                👤 {{ $transactions->first()->user_name ?? 'Unknown User' }} 
                                <span class="text-muted small">
                                    ({{ $transactions->first()->email ?? 'N/A' }}, 
                                    NID: {{ $transactions->first()->nid_number ?? 'N/A' }})
                                </span>
                            </h6>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-striped align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Date & Time</th>
                                            <th>Transaction Number</th>
                                            <th>Amount (BDT)</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $index => $txn)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($txn->created_at)->format('d M Y, h:i A') }}</td>
                                                <td>{{ $txn->transaction_number ?? 'N/A' }}</td>
                                                <td>{{ number_format($txn->amount) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $txn->type === 'deposit' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($txn->type) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No transactions found for any user.</p>
                    @endforelse

                </div>
            </div>
        @empty
            <div class="alert alert-info">No yearly user payment data available.</div>
        @endforelse

    </div>
</div>
@endsection
