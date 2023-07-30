@extends('layouts.app')

@section('content')
    <div class="col-lg-6 offset-lg-3 mb-3 align-items-center">
        <h3 class="mt-1 mb-3" style="border-bottom: 1px solid #cccccc;">
            New category
        </h3>

        <form action="/categories/" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name Category</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading icon-input"></i>
                    </span>

                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" required autofocus value="{{ old('name') }}" placeholder="Input name category">

                    @error('name')
                        <div class="invalid-feedback" style="margin-bottom: -5px">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
