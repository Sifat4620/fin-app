@extends('main.master')

@section('title', 'Clients')

@section('content')
<div class="content-body">
    <div class="container">

        <!-- Page Title -->
        <div class="row page-titles">
            <div class="col">
                <h4 class="mb-0">Clients</h4>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Clients Table -->
        <div class="card shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Client
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Branch</th>
                                <th>Vendor</th>
                                <th>Media</th>
                                <th>Last Mile</th>
                                <th>Square IP</th>
                                <th>Client IP</th>
                                <th>Router</th>
                                <th>Router Type</th>
                                <th>POP Location</th>
                                <th>Installed</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clients as $index => $client)
                                <tr>
                                    <td>{{ $clients->firstItem() + $index }}</td>
                                    <td>{{ $client->branch->branch_name ?? '-' }}</td>
                                    <td>{{ $client->vendor->vendor_name ?? '-' }}</td>
                                    <td>{{ $client->media->media_name ?? '-' }}</td>
                                    <td>{{ $client->lastMileVendor->last_mile_name ?? '-' }}</td>
                                    <td>{{ $client->square_end_ip ?? '-' }}</td>
                                    <td>{{ $client->client_end_ip ?? '-' }}</td>
                                    <td>{{ $client->connt_router ?? '-' }}</td>
                                    <td>{{ $client->router_type ?? '-' }}</td>
                                    <td>{{ $client->pop_location ?? '-' }}</td>
                                    <td>{{ $client->installation_date ?? '-' }}</td>
                                    <td>{{ Str::limit($client->remarks, 30) }}</td>
                                    <td>
                                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this client?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center">No clients found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
