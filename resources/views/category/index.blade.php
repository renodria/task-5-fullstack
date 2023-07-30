@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if ($categories->count())
                <div class="pt-2 card-header-text">
                    <h3 class="card-title fw-semibold">All Categories</h3>
                    <p class="sub-text">
                        Last update, {{ $categories[0]->updated_at->format('d F, H:i') }}
                    </p>

                    @if (session()->has('success'))
                        <div class="alert alert-success col-lg-12" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="categories/create" class="btn btn-primary">
                        Add Category
                    </a>
                </div>

                @foreach ($categories as $category)
                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                        <div class="card">
                            <div class="card bg-dark text-white" id="category">
                                <img src="https://picsum.photos/500?{{ $category->name }}" class="card-img img-fluid"
                                    alt="{{ $category->name }}" style="object-fit: cover; height: 150px;">

                                <div class="card-img-overlay d-flex align-items-center p-0">
                                    <h5 class="card-title text-center flex-fill p-4 fs-5"
                                        style="background-color: rgba(0, 0, 0, 0.7)">
                                        {{ $category->name }}

                                        <br>
                                        <a href="/categories/{{ $category->id }}" class="btn btn-info btn-sm mt-1">
                                            <i class="bi bi-eye bi-action text-white text-center"></i>
                                        </a>

                                        <a href="/categories/{{ $category->id }}/edit" class="btn btn-warning btn-sm mt-1">
                                            <i class="bi bi-pencil-square bi-action text-white"></i>
                                        </a>

                                        <form action="/categories/{{ $category->id }}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm mt-1"
                                                onclick="return confirm('Are you sure delete?')">
                                                <i class="bi bi-trash bi-action text-white"></i>
                                            </button>
                                        </form>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="error-page container">
                    <div class="col-md-8 col-12 offset-md-2">
                        <div class="text-center">
                            <h3 class="error-title fw-semibold mt-3">NOT FOUND</h3>
                            <p class='fs-5 text-gray-600'>Category not found, please add new category.</p>
                            <a href="categories/create" class="btn btn-md btn-outline-primary mt-3">Add Category</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
