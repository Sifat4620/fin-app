@extends('main.master')

@section('title', 'Create Invoice')

@section('content')
<div class="content-body py-5 bg-light">
    <div class="container">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1"><i class="mdi mdi-file-document-outline"></i> Invoice Generator</h3>
                <p class="text-muted mb-0">Fill out the form below to generate an official invoice</p>
            </div>
            <img src="{{ asset('images/logo.png') }}" alt="New Vision 19" style="height: 50px;">
        </div>

        <!-- Form Card -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form onsubmit="event.preventDefault(); generateInvoice();">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Invoice Date</label>
                            <input type="date" id="invoiceDate" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Month</label>
                            <input type="month" id="paymentMonth" class="form-control">
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
                            <select id="receiverName" class="form-select">
                                <option value="">Select Receiver</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sender Name</label>
                            <input type="text" id="senderName" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount (BDT)</label>
                            <input type="number" id="amount" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount in Words</label>
                            <input type="text" id="amountInWords" class="form-control" readonly>
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
                        <button type="button" onclick="printInvoice()" class="btn btn-primary">
                            <i class="mdi mdi-printer"></i> Preview & Print
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Printable Template -->
<!-- Upgraded Printable Template -->
<div id="invoicePreview" style="display: none;">
    <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px; max-width: 800px; margin: auto; border: 1px solid #ccc;">

        <!-- Header -->
        <div style="text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 30px;">
            <img src="{{ asset('images/logo.png') }}" style="height: 70px;" alt="New Vision 19">
            <h2 style="margin: 10px 0 5px; font-weight: bold;">NEW VISION 19</h2>
            <h3 style="margin: 0; font-weight: 500;">OFFICIAL INVOICE</h3>
        </div>

        <!-- Invoice Details -->
        <div style="margin-bottom: 30px;">
            <table style="width: 100%; font-size: 16px;">
                <tr>
                    <td><strong>Invoice Date:</strong></td>
                    <td id="p_invoice_date"></td>
                    <td><strong>Payment Month:</strong></td>
                    <td id="p_payment_month"></td>
                </tr>
                <tr>
                    <td><strong>Transaction No:</strong></td>
                    <td id="p_transaction"></td>
                    <td><strong>Receiver:</strong></td>
                    <td id="p_receiver"></td>
                </tr>
                <tr>
                    <td><strong>Sender:</strong></td>
                    <td id="p_sender"></td>
                    <td><strong>Amount:</strong></td>
                    <td><span id="p_amount"></span> BDT</td>
                </tr>
                <tr>
                    <td><strong>Amount in Words:</strong></td>
                    <td colspan="3" id="p_words" style="font-style: italic;"></td>
                </tr>
            </table>
        </div>

        <!-- Signature Section -->
        <div style="margin-top: 60px;">
            <table style="width: 100%; text-align: center; font-size: 15px;">
                <tr>
                    <td>
                        <div style="border-top: 1px solid #000; padding-top: 5px;">
                            <strong>Admin</strong><br>
                            <span id="p_sign1"></span>
                        </div>
                    </td>
                    <td>
                        <div style="border-top: 1px solid #000; padding-top: 5px;">
                            <strong>Accounts</strong><br>
                            <span id="p_sign2"></span>
                        </div>
                    </td>
                    <td>
                        <div style="border-top: 1px solid #000; padding-top: 5px;">
                            <strong>Audit</strong><br>
                            <span id="p_sign3"></span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer (Optional) -->
        <div style="text-align: center; margin-top: 40px; font-size: 13px; color: #777;">
            This is a system-generated document. For queries, contact 01712585331
        </div>
    </div>
</div>


<!-- JavaScript -->
<script>
    // Convert number to words
    function numberToWords(num) {
        const a = [
            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
            'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
        ];
        const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        const numToWords = (n) => {
            if (n < 20) return a[n];
            if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? ' ' + a[n % 10] : '');
            if (n < 1000) return a[Math.floor(n / 100)] + ' Hundred' + (n % 100 ? ' ' + numToWords(n % 100) : '');
            if (n < 100000) return numToWords(Math.floor(n / 1000)) + ' Thousand' + (n % 1000 ? ' ' + numToWords(n % 1000) : '');
            if (n < 10000000) return numToWords(Math.floor(n / 100000)) + ' Lakh' + (n % 100000 ? ' ' + numToWords(n % 100000) : '');
            return numToWords(Math.floor(n / 10000000)) + ' Crore' + (n % 10000000 ? ' ' + numToWords(n % 10000000) : '');
        };

        if (!num || isNaN(num)) return '';
        return numToWords(parseInt(num)) + ' Taka Only';
    }

    // Auto-fill amount in words
    document.getElementById('amount').addEventListener('input', function () {
        const val = this.value;
        const words = numberToWords(val);
        document.getElementById('amountInWords').value = words;
    });

    // Auto-fill amount on month select (if needed)
    document.getElementById('paymentMonth').addEventListener('change', function () {
        const month = this.value;
        fetch(`/api/get-month-total?month=${month}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('amount').value = data.amount;
                document.getElementById('amountInWords').value = data.words ?? numberToWords(data.amount);
            });
    });

    // Print logic
    function printInvoice() {
        document.getElementById('p_invoice_date').innerText = document.getElementById('invoiceDate').value;
        document.getElementById('p_payment_month').innerText = document.getElementById('paymentMonth').value;
        document.getElementById('p_transaction').innerText = document.getElementById('transactionNumber').value || 'N/A';
        document.getElementById('p_receiver').innerText = document.getElementById('receiverName').value;
        document.getElementById('p_sender').innerText = document.getElementById('senderName').value;
        document.getElementById('p_amount').innerText = document.getElementById('amount').value;
        document.getElementById('p_words').innerText = document.getElementById('amountInWords').value;
        document.getElementById('p_sign1').innerText = document.getElementById('sign1').value;
        document.getElementById('p_sign2').innerText = document.getElementById('sign2').value;
        document.getElementById('p_sign3').innerText = document.getElementById('sign3').value;

        const invoiceContent = document.getElementById('invoicePreview').innerHTML;
        const newWin = window.open('', '_blank');
        newWin.document.write('<html><head><title>Invoice</title></head><body>' + invoiceContent + '</body></html>');
        newWin.document.close();
        newWin.focus();
        newWin.print();
    }
</script>
@endsection
