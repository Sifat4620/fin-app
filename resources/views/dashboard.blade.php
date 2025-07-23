@extends('main.master')

@section('title', 'Dashboard')

@section('content')
<div class="content-body">
    <div class="container">
        <!-- Page Title & Breadcrumb -->
        <div class="row page-titles">
            <div class="col p-0">
                <h4>Hello, <span>Welcome to Admin Panel</span></h4>
            </div>
            <div class="col p-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>

        <!-- Clock -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Current Time: <span id="clock" class="text-primary"></span></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metrics Row -->
        <div class="row">
            <!-- Total Clients -->
            <div class="col-lg-3 col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4>Total Clients <i class="pull-right ion-person text-primary f-s-30"></i></h4>
                        <h6 class="m-t-20 f-s-16">{{ $counts['total_users'] }} Registered</h6>
                        <div class="progress m-t-0 h-7px">
                            <div class="progress-bar bg-primary w-100pc"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="col-lg-3 col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4>Total Transactions <i class="pull-right ion-cash text-success f-s-30"></i></h4>
                        <h6 class="m-t-20 f-s-16">{{ $counts['total_transactions'] }} Records</h6>
                        <div class="progress m-t-0 h-7px">
                            <div class="progress-bar bg-success w-100pc"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Wallet Balance -->
            <div class="col-lg-3 col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4>Total Balance <i class="pull-right ion-social-bitcoin text-warning f-s-30"></i></h4>
                        <h6 class="m-t-20 f-s-16">{{ number_format($counts['total_balance']) }} BDT</h6>
                        <div class="progress m-t-0 h-7px">
                            <div class="progress-bar bg-warning w-100pc"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branches -->
            <div class="col-lg-3 col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4>Total Branches <i class="pull-right ion-network text-danger f-s-30"></i></h4>
                        <h6 class="m-t-20 f-s-16">{{ $counts['total_branches'] }} Branches</h6>
                        <div class="progress m-t-0 h-7px">
                            <div class="progress-bar bg-danger w-100pc"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions & Users -->
        <div class="row">
            <!-- Recent Transactions -->
            <div class="col-lg-6">
                <div class="card bg-white">
                    <div class="card-body">
                        <h5>Recent Transactions</h5>
                        <ul class="list-group mt-3">
                            @forelse ($recentTransactions as $txn)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    #{{ $txn->transaction_number }}
                                    <span class="badge bg-info text-white">{{ number_format($txn->amount) }} BDT</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No transactions available.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="col-lg-6">
                <div class="card bg-white">
                    <div class="card-body">
                        <h5>New Registered Users</h5>
                        <ul class="list-group mt-3">
                            @forelse ($recentUsers as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $user->name }}
                                    <small class="text-muted">{{ $user->created_at->format('d M, Y') }}</small>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No new users found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Clock Script -->
<script>
    function updateClock() {
        const clock = document.getElementById("clock");
        const now = new Date();
        const time = now.toLocaleTimeString();
        clock.textContent = time;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endsection
