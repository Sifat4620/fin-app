@extends('main.master')

@section('title', 'Create Vendor')

@section('content')
<div class="content-body">
    <div class="container">
        <div class="row page-titles">
            <div class="col">
                <h4>Create Vendor</h4>
            </div>
            <div class="col text-right">
                <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Back to Vendors</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('vendors.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="vendor_name">Vendor Name <span class="text-danger">*</span></label>
                        <input type="text" name="vendor_name" id="vendor_name" class="form-control" value="{{ old('vendor_name') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Create Vendor</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
