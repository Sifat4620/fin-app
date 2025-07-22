@extends('main.master')
@section('title', 'Add New Branch')

@section('content')
<div class="content-body">
    <div class="container">
        <div class="row page-titles">
            <div class="col"><h4>Add New Branch</h4></div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('branches.store') }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="branch_code">Branch Code</label>
                                <input type="text" name="branch_code" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="branch_name">Branch Name</label>
                                <input type="text" name="branch_name" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Branch</button>
                            <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
