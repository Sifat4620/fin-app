@extends('main.master')

@section('title', 'Edit Media')

@section('content')
<div class="content-body">
    <div class="container">

        <!-- Page Title -->
        <div class="row page-titles">
            <div class="col">
                <h4>Edit Media</h4>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('media.update', $media->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="media_name">Media Name</label>
                                <input type="text" name="media_name" value="{{ old('media_name', $media->media_name) }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="media_convertor">Media Convertor</label>
                                <input type="text" name="media_convertor" value="{{ old('media_convertor', $media->media_convertor) }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="cabol_type">Cabol Type</label>
                                <input type="text" name="cabol_type" value="{{ old('cabol_type', $media->cabol_type) }}" class="form-control">
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">Update Media</button>
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
