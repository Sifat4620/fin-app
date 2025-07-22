@extends('main.master')

@section('title', 'Add Client')

@section('content')
<div class="content-body">
    <div class="container">

        <!-- Page Title -->
        <div class="row page-titles">
            <div class="col">
                <h4 class="mb-0">Add New Client</h4>
            </div>
            <div class="col text-end">
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Clients
                </a>
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

        <!-- Client Create Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf

                    <!-- Select Dropdowns -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="branch_id">Branch <span class="text-danger">*</span></label>
                            <select name="branch_id" id="branch_id" class="form-control" required>
                                <option value="">Select Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="vendor_id">Vendor <span class="text-danger">*</span></label>
                            <select name="vendor_id" id="vendor_id" class="form-control" required>
                                <option value="">Select Vendor</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->vendor_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="media_id">Media <span class="text-danger">*</span></label>
                            <select name="media_id" id="media_id" class="form-control" required>
                                <option value="">Select Media</option>
                                @foreach ($media as $item)
                                    <option value="{{ $item->id }}" {{ old('media_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->media_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="last_mile_vendor_id">Last Mile Vendor <span class="text-danger">*</span></label>
                            <select name="last_mile_vendor_id" id="last_mile_vendor_id" class="form-control" required>
                                <option value="">Select Last Mile Vendor</option>
                                @foreach ($lastMileVendors as $lmv)
                                    <option value="{{ $lmv->id }}" {{ old('last_mile_vendor_id') == $lmv->id ? 'selected' : '' }}>
                                        {{ $lmv->last_mile_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- IP & Connection Fields -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="square_end_ip">Square End IP</label>
                            <input type="text" name="square_end_ip" id="square_end_ip" class="form-control" value="{{ old('square_end_ip') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="client_end_ip">Client End IP</label>
                            <input type="text" name="client_end_ip" id="client_end_ip" class="form-control" value="{{ old('client_end_ip') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="connt_router">Connected Router</label>
                            <input type="text" name="connt_router" id="connt_router" class="form-control" value="{{ old('connt_router') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="router_type">Router Type</label>
                            <input type="text" name="router_type" id="router_type" class="form-control" value="{{ old('router_type') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pop_location">POP Location</label>
                            <input type="text" name="pop_location" id="pop_location" class="form-control" value="{{ old('pop_location') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="installation_date">Installation Date</label>
                            <input type="date" name="installation_date" id="installation_date" class="form-control" value="{{ old('installation_date') }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="remarks">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3" class="form-control">{{ old('remarks') }}</textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle me-1"></i> Save Client
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
