@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="pt-2 card-header-text">
                <h3 class="mb-3">{{ $post->title }}</h3>

                @if (session()->has('success'))
                    <div class="alert alert-success col-lg-12" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="col-lg-8">
                <a href="/posts" class="btn btn-success">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <a href="/posts/{{ $post->id }}/edit" class="btn btn-info text-light">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form action="/posts/{{ $post->id }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Are you sure delete?')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>

                <article class="mt-3">
                    {!! $post->content !!}
                </article>
            </div>
        </div>
    </div>
@endsection
