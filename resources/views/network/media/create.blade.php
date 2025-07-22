@extends('main.master')

@section('title', 'Add Media')

@section('content')
<div class="content-body">
    <div class="container">

        <!-- Page Title -->
        <div class="row page-titles">
            <div class="col">
                <h4>Add Media</h4>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('media.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="media_name">Media Name</label>
                                <input type="text" name="media_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="media_convertor">Media Convertor</label>
                                <input type="text" name="media_convertor" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="cabol_type">Cabol Type</label>
                                <input type="text" name="cabol_type" class="form-control">
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Save Media</button>
                                <a href="{{ route('media.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
