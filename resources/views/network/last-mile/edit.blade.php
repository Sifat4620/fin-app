@extends('main.master')

@section('title', 'Edit Last Mile Vendor')

@section('content')
<div class="content-body">
    <div class="container">

        <!-- Page Title -->
        <div class="row page-titles">
            <div class="col">
                <h4>Edit Last Mile Vendor</h4>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('last-mile.update', $vendor->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="last_mile_name">Vendor Name</label>
                                <input type="text" name="last_mile_name" value="{{ old('last_mile_name', $vendor->last_mile_name) }}" class="form-control" required>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('last-mile.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
