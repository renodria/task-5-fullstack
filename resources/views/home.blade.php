@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="pt-2 card-header-text mb-2">
                <h3 class="card-title fw-semibold">My Blog</h3>
                <p class="sub-text">
                    Last update, {{ $posts[0]->updated_at->format('d F, H:i') }}
                </p>
            </div>

            @foreach ($posts as $post)
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <div class="card rounded-3" style="max-height: 22rem;">
                        <a href="/posts/{{ $post->id }}/edit"
                            class="btn btn-md btn-info btn-outline-info position-absolute" style="left:260px; top: 7px;">
                            <i class="bi bi-lg bi-pencil text-white"></i>
                        </a>
                        <form action="/posts/{{ $post->id }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button onclick="return confirm('Are you sure delete?')"
                                class="btn btn-md btn-danger btn-outline-light position-absolute"
                                style="left:305px; top: 7px;">
                                <i class="bi bi-lg bi-trash text-white"></i>
                            </button>
                        </form>
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top img-fluid thumbnail"
                                alt="{{ $post->name }}" style="object-fit: cover; height: 125px;">
                        @else
                            <img src="img/img-post.jpg" class="img-fluid img-thumbnail" alt="{{ $post->name }}"
                                style="object-fit: cover; height: 150px;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">
                                <a href="/blog/{{ $post->title }}" class="text-decoration-none text-dark">
                                    {!! Str::limit($post->title, 20) !!}
                                </a>
                            </h5>

                            <p class="mb-1" style="margin-top:-10px;">
                                <small class="text-muted">
                                    Last update {{ $posts[0]->created_at->diffForHumans() }}
                                </small>
                            </p>

                            <p>
                                {{ strip_tags(Str::limit($post->content, 50)) }}
                            </p>

                            <a href="/posts/{{ $post->id }}" class="btn btn-primary" style="margin-top:-10px">
                                Go detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
