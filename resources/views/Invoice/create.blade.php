@extends('main.master')

@section('title', 'Create Invoice')

@section('content')
<div class="content-body py-5 bg-light">
    <div class="container">

        <!-- Invoice Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1"><i class="mdi mdi-file-document-outline"></i> Invoice Generator</h3>
                <p class="text-muted mb-0">Fill out the form below to generate an official invoice</p>
            </div>
            <img src="{{ asset('images/logo.png') }}" alt="New Vision 19" style="height: 50px;">
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Validation Errors:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Invoice Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="invoiceForm" action="{{ route('invoices.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Invoice Date</label>
                            <input type="date" name="invoice_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Month</label>
                            <input type="month" id="paymentMonth" name="payment_month" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Transaction Number (Optional)</label>
                            <select name="transaction_number" class="form-select">
                                <option value="">Select Transaction</option>
                                @foreach($transactions as $txn)
                                    <option value="{{ $txn->transaction_number }}">
                                        #{{ $txn->transaction_number }} — {{ $txn->amount }} BDT
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Receiver (User)</label>
                            <select name="receiver_name" class="form-select" required>
                                <option value="">Select Receiver</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sender Name</label>
                            <input type="text" name="sender_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount (BDT)</label>
                            <input type="number" name="amount" id="amount" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount in Words</label>
                            <input type="text" name="amount_in_words" id="amountInWords" class="form-control" required>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Authorized Signatures</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="text" name="sign_1_name" class="form-control" placeholder="Signatory 1 (Admin)">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" name="sign_2_name" class="form-control" placeholder="Signatory 2 (Accounts)">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" name="sign_3_name" class="form-control" placeholder="Signatory 3 (Audit)">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-check-circle-outline"></i> Submit & Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- JS Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- Auto Fill & PDF Download -->
<script>
    document.getElementById('paymentMonth').addEventListener('change', function () {
        const month = this.value;
        fetch(`/api/get-month-total?month=${month}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('amount').value = data.amount;
                document.getElementById('amountInWords').value = data.words;
            });
    });
</script>
@endsection
