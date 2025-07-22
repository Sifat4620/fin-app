@extends('main.master')

@section('title', 'Add Last Mile Vendor')

@section('content')
<div class="content-body">
    <div class="container">

        <!-- Page Title -->
        <div class="row page-titles">
            <div class="col">
                <h4>Add Last Mile Vendor</h4>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('last-mile.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="last_mile_name">Vendor Name</label>
                                <input type="text" name="last_mile_name" class="form-control" required>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Save</button>
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
