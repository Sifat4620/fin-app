@extends('main.master')

@section('title', 'Vendors')

@section('content')
    <div class="content-body">
        <div class="container">

            <!-- Page Title -->
            <div class="row page-titles">
                <div class="col">
                    <h4>Vendors</h4>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Vendors Table -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Vendors</h4>
                            <a href="{{ route('vendors.create') }}" class="btn btn-primary">Create Vendor</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Vendor Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vendors as $index => $vendor)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $vendor->vendor_name }}</td>
                                            <td>
                                                {{-- <a href="{{ route('vendors.show', $vendor->id) }}" class="btn btn-sm btn-info">View</a> --}}
                                                <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('vendors.destroy', $vendor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this vendor?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No vendors found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $vendors->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
