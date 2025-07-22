@extends('main.master')
@section('title', 'Make DPS Payment')

@section('content')
<div class="content-body">
    <div class="container">
        <div class="row page-titles">
            <div class="col"><h4>Make DPS Payment</h4></div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('my.payments.store') }}" method="POST">
                            @csrf

                            <!-- Transaction Number -->
                            <div class="form-group mt-3">
                                <label for="transaction_number">Transaction Number</label>
                                <input type="text" name="transaction_number" class="form-control" placeholder="Enter transaction number" required>
                            </div>

                            <!-- DPS Amount -->
                            <div class="form-group mt-3">
                                <label for="amount">DPS Amount (BDT)</label>
                                <input type="number" name="amount" class="form-control" min="1" required>
                            </div>

                            <!-- Branch -->
                            <div class="form-group mt-3">
                                <label for="branch_id">Select Branch</label>
                                <select name="branch_id" class="form-control" required>
                                    <option value="">-- Select Branch --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">
                                            {{ $branch->branch_code }} - {{ $branch->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select User -->
                            <div class="form-group mt-3">
                                <label for="user_id">Select User</label>
                                <select name="user_id" class="form-control" required>
                                    <option value="">-- Select User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ auth()->id() == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Transaction Type -->
                            <div class="form-group mt-3">
                                <label for="type">Transaction Type</label>
                                <select name="type" class="form-control" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="deposit">Deposit</option>
                                    <option value="withdraw">Withdraw</option>
                                </select>
                            </div>

                            <!-- Payment Date -->
                            <div class="form-group mt-3">
                                <label for="payment_date">Payment Date</label>
                                <input type="date" name="payment_date" class="form-control"
                                       value="{{ date('Y-m-d') }}" required>
                            </div>

                            <!-- Payment Month -->
                            <div class="form-group mt-3">
                                <label for="payment_month">Payment Month</label>
                                <select name="payment_month" class="form-control" required>
                                    <option value="">-- Select Month --</option>
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ date('F', mktime(0, 0, 0, $m, 1)) }}">
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Note -->
                            <div class="form-group mt-3">
                                <label for="note">Payment Note (Optional)</label>
                                <textarea name="note" class="form-control" rows="2" placeholder="Any comment or reference..."></textarea>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success">Submit Payment</button>
                                <a href="{{ route('my.payments.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
