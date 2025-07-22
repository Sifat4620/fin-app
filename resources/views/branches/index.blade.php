@extends('main.master')

@section('title', 'Branch List')

@section('content')
<div class="content-body">
    <div class="container">

        <div class="row page-titles">
            <div class="col">
                <h4>All Branches</h4>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Branch Table</h5>
                <a href="{{ route('branches.create') }}" class="btn btn-primary">Add New Branch</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($branches as $index => $branch)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $branch->branch_code }}</td>
                                <td>{{ $branch->branch_name }}</td>
                                <td>{{ $branch->location }}</td>
                                <td>
                                    <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this branch?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No branches found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $branches->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
