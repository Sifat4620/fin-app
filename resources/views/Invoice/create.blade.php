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
                <form id="invoiceForm" onsubmit="event.preventDefault(); saveAndPrintInvoice();">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Invoice Date</label>
                            <input type="date" name="invoice_date" id="invoiceDate" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Month</label>
                            <input type="month" name="payment_month" id="paymentMonth" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Transaction Number (Optional)</label>
                            <select name="transaction_number" id="transactionNumber" class="form-select">
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
                            <select name="receiver_name" id="receiverName" class="form-select">
                                <option value="">Select Receiver</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sender Name</label>
                            <input type="text" name="sender_name" id="senderName" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount (BDT)</label>
                            <input type="number" name="amount" id="amount" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount in Words</label>
                            <input type="text" name="amount_in_words" id="amountInWords" class="form-control" readonly>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Authorized Signatures</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="text" name="sign_1_name" id="sign1" class="form-control" placeholder="Signatory 1 (Admin)">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" name="sign_2_name" id="sign2" class="form-control" placeholder="Signatory 2 (Accounts)">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" name="sign_3_name" id="sign3" class="form-control" placeholder="Signatory 3 (Audit)">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-printer"></i> Save & Print
                        </button>
                    </div>
                </form>
            </div>
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
        return numToWords(parseInt(num)) + ' Taka Only';
    }

    document.getElementById('amount').addEventListener('input', function () {
        document.getElementById('amountInWords').value = numberToWords(this.value);
    });

    function saveAndPrintInvoice() {
        const form = document.getElementById('invoiceForm');
        const formData = new FormData(form);

        fetch("{{ route('invoices.store') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => {
            if (!res.ok) throw new Error('Failed to save');
            return res.json();
        })
        .then(() => {
            const data = Object.fromEntries(formData.entries());
            const html = `
                <html><head><title>Invoice</title></head><body style="font-family:Arial;padding:20px;">
                <img src='{{ asset('images/logo.png') }}' style='height:50px;'><h2>Invoice</h2>
                <p><strong>Date:</strong> ${data.invoice_date}</p>
                <p><strong>Payment Month:</strong> ${data.payment_month}</p>
                <p><strong>Transaction:</strong> ${data.transaction_number || 'N/A'}</p>
                <p><strong>Receiver:</strong> ${data.receiver_name}</p>
                <p><strong>Sender:</strong> ${data.sender_name}</p>
                <p><strong>Amount:</strong> ${data.amount} BDT</p>
                <p><strong>In Words:</strong> ${data.amount_in_words}</p>
                <div style='display:flex;justify-content:space-between;margin-top:50px;'>
                    <div><strong>Admin</strong><br>${data.sign_1_name}</div>
                    <div><strong>Accounts</strong><br>${data.sign_2_name}</div>
                    <div><strong>Audit</strong><br>${data.sign_3_name}</div>
                </div>
                <script>window.onload = () => window.print();<\/script>
                </body></html>`;
            const win = window.open('', '_blank');
            win.document.write(html);
            win.document.close();
        })
        .catch(err => alert(err.message));
    }
</script>
@endsection
