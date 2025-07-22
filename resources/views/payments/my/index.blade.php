@extends('main.master')
@section('title', 'My Payments')

@section('content')
<div class="content-body">
    <div class="container">
        
        <!-- Page Title -->
        <div class="row page-titles mb-3">
            <div class="col">
                <h4><i class="mdi mdi-wallet-outline"></i> My Payments</h4>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Wallet Info -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Wallet Balance: <strong>{{ $wallet->balance }} BDT</strong></h5>
                <a href="{{ route('my.payments.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-cash-plus"></i> Make DPS Payment
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Transactions -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="mdi mdi-cash-multiple"></i> Transactions</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($transactions as $tx)
                                <li class="list-group-item d-flex justify-content-between align-items-start flex-column">
                                    <div class="w-100">
                                        <strong>{{ ucfirst($tx->type) }} - {{ $tx->amount }} BDT</strong>
                                        <br>
                                        <small>{{ $tx->created_at->format('d M, Y h:i A') }}</small>
                                    </div>
                                    <div class="mt-2 text-end w-100">
                                        @if($tx->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($tx->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($tx->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center">No transactions found.</li>
                            @endforelse
                        </ul>
                        <div class="mt-3">{{ $transactions->links() }}</div>
                    </div>
                </div>
            </div>

            <!-- Transfers -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="mdi mdi-swap-horizontal"></i> Transfers</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($transfers as $tr)
                                <li class="list-group-item d-flex justify-content-between align-items-start flex-column">
                                    <div class="w-100">
                                        Fee: {{ $tr->fee }} BDT
                                        <br>
                                        <small>{{ $tr->created_at->format('d M, Y h:i A') }}</small>
                                    </div>
                                    <div class="mt-2 text-end w-100">
                                        @if($tr->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($tr->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($tr->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center">No transfers found.</li>
                            @endforelse
                        </ul>
                        <div class="mt-3">{{ $transfers->links() }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
