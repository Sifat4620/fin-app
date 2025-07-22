@extends('main.master')

@section('title', 'Invoices')

@section('content')
<div class="content-body">
    <div class="container">

        <!-- Page Title -->
        <div class="row page-titles mb-3">
            <div class="col">
                <h4><i class="mdi mdi-file-document-outline"></i> Invoices</h4>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Invoices Table Card -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Invoice List</h5>
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus"></i> Create New Invoice
                </a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Receiver</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Month</th>
                            <th>Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $index => $invoice)
                            <tr>
                                <td>{{ ($invoices->currentPage() - 1) * $invoices->perPage() + $index + 1 }}</td>
                                <td>{{ $invoice->receiver_name ?? 'N/A' }}</td>
                                <td>{{ number_format($invoice->amount, 2) }} BDT</td>
                                <td>
                                    <span class="badge bg-{{ match($invoice->status ?? 'unknown') {
                                        'paid' => 'success',
                                        'due' => 'warning',
                                        'overdue' => 'danger',
                                        'canceled' => 'secondary',
                                        'refunded' => 'info',
                                        default => 'dark'
                                    } }}">
                                        {{ ucfirst($invoice->status ?? 'N/A') }}
                                    </span>
                                </td>
                                <td>{{ $invoice->payment_month ?? 'N/A' }}</td>
                                <td>{{ $invoice->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info me-1" title="View">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    {{-- Optional: Print/PDF --}}
                                    {{-- <a href="{{ route('invoices.print', $invoice) }}" class="btn btn-sm btn-primary me-1" title="Print">
                                        <i class="mdi mdi-printer"></i>
                                    </a> --}}
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Delete">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No invoices found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
