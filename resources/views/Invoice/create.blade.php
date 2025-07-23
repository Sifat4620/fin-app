@extends('main.master')

@section('title', 'Create Invoice')

@section('content')
<div class="content-body py-5 bg-light">
    <div class="container">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1"><i class="mdi mdi-file-document-outline"></i> Invoice Generator</h3>
                <p class="text-muted mb-0">Fill out the form below to generate and print an official invoice</p>
            </div>
            <img src="{{ asset('images/logo.png') }}" alt="New Vision 19" style="height: 50px;">
        </div>

        <!-- Alert -->
        <div id="alertBox" class="alert d-none"></div>

        <!-- Form Card -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="invoiceForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Invoice Date</label>
                            <input type="date" id="invoiceDate" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Month</label>
                            <input type="month" id="paymentMonth" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Transaction Number (Optional)</label>
                            <select id="transactionNumber" class="form-select">
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
                            <select id="receiverName" class="form-select" required>
                                <option value="">Select Receiver</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sender Name</label>
                            <input type="text" id="senderName" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount (BDT)</label>
                            <input type="number" id="amount" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount in Words</label>
                            <input type="text" id="amountInWords" class="form-control" readonly required>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Authorized Signatures</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="text" id="sign1" class="form-control" placeholder="Signatory 1 (Admin)">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="sign2" class="form-control" placeholder="Signatory 2 (Accounts)">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="sign3" class="form-control" placeholder="Signatory 3 (Audit)">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-printer"></i> Save & Print Invoice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Printable Template -->
<div id="invoicePreview" style="display: none;">
    <div style="font-family: Arial, sans-serif; padding: 40px;">
        <div style="text-align: center;">
            <img src="{{ asset('images/logo.png') }}" style="height: 60px;" alt="New Vision 19">
            <h2 style="border-bottom: 2px solid #000; padding-bottom: 10px; margin: 20px 0;">INVOICE</h2>
        </div>
        <div>
            <p><strong>Invoice Date:</strong> <span id="p_invoice_date"></span></p>
            <p><strong>Payment Month:</strong> <span id="p_payment_month"></span></p>
            <p><strong>Transaction Number:</strong> <span id="p_transaction"></span></p>
            <p><strong>Receiver:</strong> <span id="p_receiver"></span></p>
            <p><strong>Sender:</strong> <span id="p_sender"></span></p>
            <p><strong>Amount:</strong> <span id="p_amount"></span> BDT</p>
            <p><strong>Amount in Words:</strong> <span id="p_words"></span></p>
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 50px;">
            <div style="text-align: center;"><strong>Admin</strong><br><span id="p_sign1"></span></div>
            <div style="text-align: center;"><strong>Accounts</strong><br><span id="p_sign2"></span></div>
            <div style="text-align: center;"><strong>Audit</strong><br><span id="p_sign3"></span></div>
        </div>
    </div>
</div>

<script>
    function numberToWords(num) {
        const a = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
                   'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        const numToWords = (n) => {
            if (n < 20) return a[n];
            if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? ' ' + a[n % 10] : '');
            if (n < 1000) return a[Math.floor(n / 100)] + ' Hundred' + (n % 100 ? ' ' + numToWords(n % 100) : '');
            if (n < 100000) return numToWords(Math.floor(n / 1000)) + ' Thousand' + (n % 1000 ? ' ' + numToWords(n % 1000) : '');
            if (n < 10000000) return numToWords(Math.floor(n / 100000)) + ' Lakh' + (n % 100000 ? ' ' + numToWords(n % 100000) : '');
            return numToWords(Math.floor(n / 10000000)) + ' Crore' + (n % 10000000 ? ' ' + numToWords(n % 10000000) : '');
        };
        return (!num || isNaN(num)) ? '' : numToWords(parseInt(num)) + ' Taka Only';
    }

    document.getElementById('amount').addEventListener('input', function () {
        document.getElementById('amountInWords').value = numberToWords(this.value);
    });

    document.getElementById('invoiceForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const payload = {
            invoice_date: document.getElementById('invoiceDate').value,
            amount: document.getElementById('amount').value,
            amount_in_words: document.getElementById('amountInWords').value,
            payment_month: document.getElementById('paymentMonth').value,
            receiver_name: document.getElementById('receiverName').value,
            sender_name: document.getElementById('senderName').value,
            transaction_number: document.getElementById('transactionNumber').value || null,
            sign_1_name: document.getElementById('sign1').value,
            sign_2_name: document.getElementById('sign2').value,
            sign_3_name: document.getElementById('sign3').value
        };

        fetch("{{ route('invoices.store') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                fillAndPrintInvoice(payload);
            } else {
                alert("Error: Invoice could not be saved.");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Unexpected error occurred.");
        });
    });

    function fillAndPrintInvoice(data) {
        document.getElementById('p_invoice_date').innerText = data.invoice_date;
        document.getElementById('p_payment_month').innerText = data.payment_month;
        document.getElementById('p_transaction').innerText = data.transaction_number || 'N/A';
        document.getElementById('p_receiver').innerText = data.receiver_name;
        document.getElementById('p_sender').innerText = data.sender_name;
        document.getElementById('p_amount').innerText = data.amount;
        document.getElementById('p_words').innerText = data.amount_in_words;
        document.getElementById('p_sign1').innerText = data.sign_1_name;
        document.getElementById('p_sign2').innerText = data.sign_2_name;
        document.getElementById('p_sign3').innerText = data.sign_3_name;

        const invoiceContent = document.getElementById('invoicePreview').innerHTML;
        const win = window.open('', '_blank');
        win.document.write('<html><head><title>Invoice</title></head><body>' + invoiceContent + '</body></html>');
        win.document.close();
        win.focus();
        win.print();
    }
</script>
@endsection
