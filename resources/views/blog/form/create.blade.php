@extends('layouts.app')

@section('content')
    <div class="col-lg-6 offset-lg-3 mb-3 align-items-center">
        <h3 class="mt-1 mb-3" style="border-bottom: 1px solid #cccccc;">
            New post blog
        </h3>

        <form action="/posts/" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Title -->
            <div class="mb-1">
                <label for="title" class="form-label">Title</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading icon-input"></i>
                    </span>

                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                        id="title" required autofocus value="{{ old('title') }}" placeholder="Input your title">

                    @error('title')
                        <div class="invalid-feedback" style="margin-bottom: -5px">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Category -->
            <div class="mb-1">
                <label for="category" class="form-label">Category</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">
                        <i class="bi bi-tag icon-input" style="rotate: 90deg"></i>
                    </span>

                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                        <option disabled selected>Select your category</option>
                        @foreach ($categories as $category)
                            @if (old('category_id') == $category->id)
                                <option value="{{ $category->id }}" selected>
                                    {{ $category->name }}
                                </option>
                            @else
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Image -->
            <div class="mb-2">
                <label for="formFile" class="form-label">Post Image</label>
                <img class="img-preview img-fluid mb-3 col-sm-4">
                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image"
                    id="image" onchange="previewImage()">
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-2">
                <label for="content" class="form-label mb-1">Content</label>
                @error('content')
                    <div class="text-danger invalid-content">{{ $message }}</div>
                @enderror

                <input name="content" id="content" type="hidden" value="{{ old('content') }}">
                <trix-editor input="content"></trix-editor>
            </div>

            <input type="hidden" name="status" value="Unfinished">

            <a href="/categories" class="btn btn-secondary px-3">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
      const title = document.querySelector("#title");
      const slug = document.querySelector("#slug");

      title.addEventListener("keyup", function() {
          let preslug = title.value;
          preslug = preslug.replace(/ /g, "-");
          slug.value = preslug.toLowerCase();
      });

      document.addEventListener('trix-file-accept', function(e) {
          e.preventDefault();
      });
      
      function previewImage() {
          const image = document.querySelector('#image');
          const imgPreview = document.querySelector('.img-preview');
          const blob = URL.createObjectURL(image.files[0]);

          imgPreview.src = blob;
          imgPreview.style.display = 'block';
      }
  </script>
@endsection
