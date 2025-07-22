@extends('main.master')

@section('title', 'Edit Vendor')

@section('content')
<div class="content-body">
    <div class="container">

        <!-- Page Title -->
        <div class="row page-titles">
            <div class="col">
                <h4>Edit Vendor</h4>
            </div>
            <div class="col text-right">
                <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Back to Vendors</a>
            </div>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Vendor Card -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">Update Vendor Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('vendors.update', ['id' => $vendor->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="vendor_name">Vendor Name <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            name="vendor_name" 
                            id="vendor_name" 
                            class="form-control" 
                            value="{{ old('vendor_name', $vendor->vendor_name) }}" 
                            required
                        >
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-warning">Update Vendor</button>
                        <a href="{{ route('vendors.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
