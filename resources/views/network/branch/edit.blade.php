@extends('main.master')

@section('title', 'Edit Branch')

@section('content')
<div class="content-body">
    <div class="container">

        <!-- Page Title & Back -->
        <div class="row page-titles align-items-center">
            <div class="col">
                <h4 class="mb-0">Edit Branch</h4>
            </div>
            <div class="col text-end">
                <a href="{{ route('branches.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Branches
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

        <!-- Edit Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('branches.update', $branch->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Branch Code -->
                    <div class="form-group mb-3">
                        <label for="branch_code">Branch Code (optional)</label>
                        <input 
                            type="text" 
                            name="branch_code" 
                            id="branch_code" 
                            class="form-control @error('branch_code') is-invalid @enderror"
                            value="{{ old('branch_code', $branch->branch_code) }}"
                        >
                        @error('branch_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Branch Name -->
                    <div class="form-group mb-3">
                        <label for="branch_name">Branch Name <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            name="branch_name" 
                            id="branch_name" 
                            class="form-control @error('branch_name') is-invalid @enderror"
                            value="{{ old('branch_name', $branch->branch_name) }}"
                            required
                        >
                        @error('branch_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location (optional) -->
                    <div class="form-group mb-3">
                        <label for="location">Location</label>
                        <input 
                            type="text" 
                            name="location" 
                            id="location" 
                            class="form-control @error('location') is-invalid @enderror"
                            value="{{ old('location', $branch->location) }}"
                        >
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i> Update Branch
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
