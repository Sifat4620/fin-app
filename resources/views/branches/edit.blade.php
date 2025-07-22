@extends('main.master')
@section('title', 'Edit Branch')

@section('content')
<div class="content-body">
    <div class="container">
        <div class="row page-titles">
            <div class="col"><h4>Edit Branch</h4></div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('branches.update', $branch->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="branch_code">Branch Code</label>
                                <input type="text" name="branch_code" class="form-control" value="{{ $branch->branch_code }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="branch_name">Branch Name</label>
                                <input type="text" name="branch_name" class="form-control" value="{{ $branch->branch_name }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="form-control" value="{{ $branch->location }}" required>
                            </div>

                            <button type="submit" class="btn btn-success">Update Branch</button>
                            <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
