@extends('layouts.app')

@section('title', 'Blog List')

@section('content')
<div class="container">
    <h2 class="mb-4">Blog List</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($blogs as $blog)
        <div class="card mb-3">
            <div class="row g-0">
                @if($blog->image)
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid rounded-start" alt="Blog Image">
                    </div>
                @endif
                <div class="col-md-8">
                    <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('blogs.show', $blog->id) }}" class="text-decoration-none">
                            {{ $blog->title }}
                        </a>
                    </h5>
                        <p class="card-text">{!! Str::limit($blog->description, 250) !!}</p>
                        @auth
                        <div class="d-inline-block">
                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
